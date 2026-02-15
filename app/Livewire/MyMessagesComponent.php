<?php

namespace App\Livewire;

use App\Models\ServiceChatMessage;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MyMessagesComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $isCustomer = $user->utype === 'CST';
        $isProvider = $user->utype === 'SVP';

        $serviceIds = [];
        if ($isProvider) {
            $sprovider = ServiceProvider::where('user_id', $user->id)->first();
            if ($sprovider) {
                $serviceIds = $sprovider->services()->pluck('id')->all();
            }
        }

        $latestQuery = ServiceChatMessage::select('service_id', 'customer_id', DB::raw('MAX(created_at) as last_at'))
            ->groupBy('service_id', 'customer_id');

        if ($isCustomer) {
            $latestQuery->where('customer_id', $user->id);
        }
        if ($isProvider) {
            $latestQuery->whereIn('service_id', $serviceIds);
        }

        $threads = ServiceChatMessage::from('service_chat_messages as m')
            ->joinSub($latestQuery, 't', function ($join) {
                $join->on('m.service_id', '=', 't.service_id')
                    ->on('m.customer_id', '=', 't.customer_id')
                    ->on('m.created_at', '=', 't.last_at');
            })
            ->join('services as s', 'm.service_id', '=', 's.id')
            ->leftJoin('service_providers as sp', 's.service_provider_id', '=', 'sp.id')
            ->leftJoin('users as prov', 'sp.user_id', '=', 'prov.id')
            ->leftJoin('users as cust', 'm.customer_id', '=', 'cust.id')
            ->select(
                'm.service_id',
                'm.customer_id',
                'm.message',
                'm.created_at',
                's.name as service_name',
                's.slug as service_slug',
                'prov.name as provider_name',
                'cust.name as customer_name'
            )
            ->orderByDesc('m.created_at')
            ->get();

        return view('livewire.my-messages-component', [
            'threads' => $threads,
            'isCustomer' => $isCustomer,
            'isProvider' => $isProvider
        ])->layout('layouts.base');
    }
}
