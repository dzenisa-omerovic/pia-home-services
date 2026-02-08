<?php

use App\Http\Controllers\SearchController;
use App\Livewire\Admin\AdminAddServiceCategoryComponent;
use App\Livewire\Admin\AdminAddServiceComponent;
use App\Livewire\Admin\AdminAddSlideComponent;
use App\Livewire\Admin\AdminContactComponent;
use App\Livewire\Admin\AdminDashboardComponent;
use App\Livewire\Admin\AdminEditServiceCategoryComponent;
use App\Livewire\Admin\AdminEditServiceComponent;
use App\Livewire\Admin\AdminEditSlideComponent;
use App\Livewire\Admin\AdminServiceCategoryComponent;
use App\Livewire\Admin\AdminServiceProvidersComponent;
use App\Livewire\Admin\AdminServicesByCategoryComponent;
use App\Livewire\Admin\AdminServicesComponent;
use App\Livewire\Admin\AdminSliderComponent;
use App\Livewire\ChangeLocationComponent;
use App\Livewire\ContactComponent;
use App\Livewire\Customer\CustomerDashboardComponent;
use App\Livewire\HomeComponent;
use App\Livewire\ServiceByCategoryComponent;
use App\Livewire\ServiceCategoriesComponent;
use App\Livewire\ServiceDetailsComponent;
use App\Livewire\Sprovider\EditSproviderProfileComponent;
use App\Livewire\Sprovider\SproviderAddServiceComponent;
use App\Livewire\Sprovider\SproviderDashboardComponent;
use App\Livewire\Sprovider\SproviderEditServiceComponent;
use App\Livewire\Sprovider\SproviderProfileComponent;
use App\Livewire\Sprovider\SproviderServicesComponent;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class)->name('home');
Route::get('/service-categories', ServiceCategoriesComponent::class)->name('home.service_categories');
Route::get('/service/{service_slug}', ServiceDetailsComponent::class)->name('home.service_details');

Route::get('/autocomplete', [SearchController::class, 'autocomplete'] )->name('autocomplete');
Route::post('/search', [SearchController::class, 'searchService'] )->name('searchService');

Route::get('/change-location', ChangeLocationComponent::class)->name('home.change_location');

Route::get('/contact-us', ContactComponent::class)->name('home.contact');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/customer/dashboard', CustomerDashboardComponent::class)->name('customer.dashboard');
});

Route::middleware(['auth:sanctum', 'verified', 'authsprovider'])->group(function(){
    Route::get('/sprovider/dashboard', SproviderDashboardComponent::class)->name('sprovider.dashboard');
    Route::get('/sprovider/profile', SproviderProfileComponent::class)->name('sprovider.profile');
    Route::get('/sprovider/profile/edit', EditSproviderProfileComponent::class)->name('sprovider.edit_profile');
    Route::get('/sprovider/service/add', SproviderAddServiceComponent::class)->name('sprovider.add_service');
    Route::get('/sprovider/service/edit/{service_slug}', SproviderEditServiceComponent::class)->name('sprovider.edit_service');
    Route::get('/sprovider/services', SproviderServicesComponent::class)->name('sprovider.services');
});

Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){
    Route::get('/admin/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
    Route::get('/admin/service-categories', AdminServiceCategoryComponent::class)->name('admin.service_categories');
    Route::get('/admin/service-category/add', AdminAddServiceCategoryComponent::class)->name('admin.add_service_category');
    Route::get('/admin/service-category/edit{category_id}', AdminEditServiceCategoryComponent::class)->name('admin.edit_service_category');
    Route::get('/admin/all-services', AdminServicesComponent::class)->name('admin.all_services');
    Route::get('/admin/{category_slug}/services', AdminServicesByCategoryComponent::class)->name('admin.services_by_category');
    Route::get('/admin/service/add', AdminAddServiceComponent::class)->name('admin.add_service');
    Route::get('/admin/service/edit/{service_slug}', AdminEditServiceComponent::class)->name('admin.edit_service');

    Route::get('/admin/slider', AdminSliderComponent::class)->name('admin.slider');
    Route::get('/admin/slide/add', AdminAddSlideComponent::class)->name('admin.add_slide');
    Route::get('/admin/slide/edit/{slide_id}', AdminEditSlideComponent::class)->name('admin.edit_slide');
    Route::get('/admin/contacts', AdminContactComponent::class)->name('admin.contacts');
    Route::get('/admin/service-providers', AdminServiceProvidersComponent::class)->name('admin.service_providers');
});

// Keep this after all other routes to avoid shadowing more specific paths like /sprovider/services
Route::get('/{category_slug}/services', ServiceByCategoryComponent::class)->name('home.services_by_category');
