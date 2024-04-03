<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

new class extends Component
{
    public string $accessToken = '';

    /**
     * Delete the currently authenticated user.
     */
    public function resetKey(): void
    {
        PersonalAccessToken::where('tokenable_id','=',Auth()->id())->delete();
        $this->accessToken = (Auth()->user())->createToken('API token')->plainTextToken;
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Reset API key') }}
        </h2>
    </header>

    @if(strlen($accessToken) > 0)
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Important: Please save your API key securely as it will not be visible after this page reloads. You can always create a new API key if needed, but doing so will invalidate the old one.') }}
        </p>
        <p>{{$accessToken}}</p>
    @endif
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-key-reset')"
    >{{ __('Reset key') }}</x-danger-button>

    <x-modal name="confirm-key-reset" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="resetKey" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to reset API key?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" x-on:click="$dispatch('close')">
                    {{ __('Reset API key') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
