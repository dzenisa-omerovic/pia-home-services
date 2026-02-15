<?php

use App\Http\Controllers\SearchController;
use App\Livewire\Admin\AdminAddServiceCategoryComponent;
use App\Livewire\Admin\AdminAddServiceComponent;
use App\Livewire\Admin\AdminAddSlideComponent;
use App\Livewire\Admin\AdminContactComponent;
use App\Livewire\Admin\AdminCustomersComponent;
use App\Livewire\Admin\AdminDashboardComponent;
use App\Livewire\Admin\AdminEditServiceCategoryComponent;
use App\Livewire\Admin\AdminEditServiceComponent;
use App\Livewire\Admin\AdminEditSlideComponent;
use App\Livewire\Admin\AdminServiceCategoryComponent;
use App\Livewire\Admin\AdminServiceProvidersComponent;
use App\Livewire\Admin\AdminServicesByCategoryComponent;
use App\Livewire\Admin\AdminServicesComponent;
use App\Livewire\Admin\AdminSecuritySettingsComponent;
use App\Livewire\Admin\AdminSliderComponent;
use App\Livewire\ChangeLocationComponent;
use App\Livewire\ContactComponent;
use App\Livewire\Customer\CustomerProfileComponent;
use App\Livewire\Customer\CustomerInterestsComponent;
use App\Livewire\Customer\CustomerComplaintComponent;
use App\Livewire\Customer\CustomerReviewProviderComponent;
use App\Livewire\Customer\CustomerServiceRequestsComponent;
use App\Livewire\Customer\EditCustomerProfileComponent;
use App\Livewire\Customer\CustomerDashboardComponent;
use App\Livewire\HomeComponent;
use App\Livewire\ServiceByCategoryComponent;
use App\Livewire\ServiceCategoriesComponent;
use App\Livewire\ServiceChatPageComponent;
use App\Livewire\ServiceProvidersComponent;
use App\Livewire\ServiceProviderDetailsComponent;
use App\Livewire\ServiceProviderServicesComponent;
use App\Livewire\ServiceDetailsComponent;
use App\Livewire\ServiceMessagesComponent;
use App\Livewire\ServicesComponent;
use App\Livewire\MyMessagesComponent;
use App\Livewire\Sprovider\EditSproviderProfileComponent;
use App\Livewire\Sprovider\SproviderAddServiceComponent;
use App\Livewire\Sprovider\SproviderAvailabilityComponent;
use App\Livewire\Sprovider\SproviderComplaintsComponent;
use App\Livewire\Sprovider\SproviderComplaintReplyComponent;
use App\Livewire\Sprovider\SproviderDashboardComponent;
use App\Livewire\Sprovider\SproviderEditServiceComponent;
use App\Livewire\Sprovider\SproviderProfileComponent;
use App\Livewire\Sprovider\SproviderReviewCustomerComponent;
use App\Livewire\Sprovider\SproviderServiceRequestsComponent;
use App\Livewire\Sprovider\SproviderServicesComponent;
use App\Livewire\Sprovider\SproviderReviewsComponent;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class)->name('home');
Route::get('/service-categories', ServiceCategoriesComponent::class)->name('home.service_categories');
Route::get('/service-providers', ServiceProvidersComponent::class)->name('home.service_providers');
Route::get('/service-provider/{provider_id}', ServiceProviderDetailsComponent::class)->name('home.service_provider_details');
Route::get('/service-provider/{provider_id}/services', ServiceProviderServicesComponent::class)->name('home.service_provider_services');
Route::get('/service/{service_slug}', ServiceDetailsComponent::class)->name('home.service_details');
Route::get('/services', ServicesComponent::class)->name('home.services');

Route::get('/autocomplete', [SearchController::class, 'autocomplete'] )->name('autocomplete');
Route::post('/search', [SearchController::class, 'searchService'] )->name('searchService');



Route::get('/contact-us', ContactComponent::class)
    ->middleware('contact.access')
    ->name('home.contact');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/customer/dashboard', CustomerDashboardComponent::class)->name('customer.dashboard');
    Route::get('/customer/profile', CustomerProfileComponent::class)->name('customer.profile');
    Route::get('/customer/interests', CustomerInterestsComponent::class)->name('customer.interests');
    Route::get('/customer/profile/edit', EditCustomerProfileComponent::class)->name('customer.edit_profile');
    Route::get('/customer/requests', CustomerServiceRequestsComponent::class)->name('customer.requests');
    Route::get('/customer/complaint/{request_id}', CustomerComplaintComponent::class)->name('customer.complaint');
    Route::get('/customer/review/{request_id}', CustomerReviewProviderComponent::class)->name('customer.review_provider');
    Route::get('/messages/{request_id}', ServiceMessagesComponent::class)->name('messages.thread');
    Route::get('/my-messages', MyMessagesComponent::class)->name('messages.index');
    Route::get('/service/{service_slug}/chat/{customer_id?}', ServiceChatPageComponent::class)->name('service.chat');
});

Route::middleware(['auth:sanctum', 'verified', 'authsprovider'])->group(function(){
    Route::get('/sprovider/dashboard', SproviderDashboardComponent::class)->name('sprovider.dashboard');
    Route::get('/sprovider/profile', SproviderProfileComponent::class)->name('sprovider.profile');
    Route::get('/sprovider/profile/edit', EditSproviderProfileComponent::class)->name('sprovider.edit_profile');
    Route::get('/sprovider/service/add', SproviderAddServiceComponent::class)->name('sprovider.add_service');
    Route::get('/sprovider/service/edit/{service_slug}', SproviderEditServiceComponent::class)->name('sprovider.edit_service');
    Route::get('/sprovider/services', SproviderServicesComponent::class)->name('sprovider.services');
    Route::get('/sprovider/requests', SproviderServiceRequestsComponent::class)->name('sprovider.requests');
    Route::get('/sprovider/availability', SproviderAvailabilityComponent::class)->name('sprovider.availability');
    Route::get('/sprovider/review/{request_id}', SproviderReviewCustomerComponent::class)->name('sprovider.review_customer');
    Route::get('/sprovider/reviews', SproviderReviewsComponent::class)->name('sprovider.reviews');
    Route::get('/sprovider/complaints', SproviderComplaintsComponent::class)->name('sprovider.complaints');
    Route::get('/sprovider/complaint/{complaint_id}', SproviderComplaintReplyComponent::class)->name('sprovider.complaint_reply');
});

Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){
    Route::get('/admin/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
    Route::get('/admin/service-categories', AdminServiceCategoryComponent::class)->name('admin.service_categories');
    Route::get('/admin/service-category/add', AdminAddServiceCategoryComponent::class)->name('admin.add_service_category');
    Route::get('/admin/service-category/edit{category_id}', AdminEditServiceCategoryComponent::class)->name('admin.edit_service_category');
    Route::get('/admin/all-services', AdminServicesComponent::class)->name('admin.all_services');
    Route::get('/admin/{category_slug}/services', AdminServicesByCategoryComponent::class)->name('admin.services_by_category');
    Route::get('/admin/service/add', AdminAddServiceComponent::class)->name('admin.add_service');
    Route::get('/admin/service/edit/{service_id}', AdminEditServiceComponent::class)->name('admin.edit_service');

    Route::get('/admin/slider', AdminSliderComponent::class)->name('admin.slider');
    Route::get('/admin/slide/add', AdminAddSlideComponent::class)->name('admin.add_slide');
    Route::get('/admin/slide/edit/{slide_id}', AdminEditSlideComponent::class)->name('admin.edit_slide');
    Route::get('/admin/contacts', AdminContactComponent::class)->name('admin.contacts');
    Route::get('/admin/customers', AdminCustomersComponent::class)->name('admin.customers');
    Route::get('/admin/service-providers', AdminServiceProvidersComponent::class)->name('admin.service_providers');
    Route::get('/admin/security-settings', AdminSecuritySettingsComponent::class)->name('admin.security_settings');
});

// Keep this after all other routes to avoid shadowing more specific paths like /sprovider/services
Route::get('/{category_slug}/services', ServiceByCategoryComponent::class)->name('home.services_by_category');
