<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{route('login')}}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <div class="col-6">
            @if(Session::has('success'))
            <script>
                alert('OTP Verifed Successfully')
            </script>

            @endif
            @if(Session::has('error'))
            <script>
                alert('OTP ERROR')
            </script>
            @endif
        </div>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your OTP before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('otp.confirm') }}">
            @csrf
            <!-- OTP Verification -->
            <div>
                <x-label for="otp" :value="__('OTP')" />
                <x-input id="otp" class="block mt-1 w-full" type="text" name="otp" />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
