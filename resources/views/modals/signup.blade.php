<div class="modal fade" id="customerSignUpModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="customerSignUpModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="customerSignUpModalLongTitle">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="tab-content" id="myTabContent">
            
            <div id="signupform1" class="tab-pane fade show active max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form class="form-horizontal" action="javascript:void(0)">
                    @csrf
                    <!-- Product Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-label for="phone_number" :value="__('Phone Number')" />

                        <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" required />
                    </div>

                    <!-- Password -->

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button 
                            id="signupbutton1"
                            data-toggle="tab" href="#signupform2" role="tab" aria-controls="signupform2"
                            class="ml-4">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="signupform2" role="tabpanel" aria-labelledby="signupform2-tab">
                <form class="form-horizontal" action="javascript:void(0)">
                    @csrf
                    <p id="phone_number"></p>
                    <div class="mt-4">
                        <x-label for="verification" :value="__('Enter Verification Code')" />

                        <x-input id="verification" class="block mt-1 w-full" type="text" name="verification" :value="old('verification')" required />
                    </div>

                    <!-- Password -->

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button 
                            id="signupbutton2"
                            data-toggle="tab" href="#" role="tab" aria-controls="signupform2"
                            class="ml-4">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>