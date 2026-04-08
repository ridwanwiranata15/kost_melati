<div>

<form wire:submit="createNewUser" class="max-w-sm mx-auto">
  <div class="mb-5">
    <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Your email</label>
    <input wire:model="email" type="email" id="email" class="w-full py-3 px-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all shadow-sm" placeholder="name@flowbite.com" required />
  </div>
  <div class="mb-5">
    <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Your name</label>
    <input wire:model="name" type="text" id="email" class="w-full py-3 px-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all shadow-sm" placeholder="Full name" required />
  </div>
  <div class="mb-5">
    <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Your password</label>
    <input wire:model="password" type="password" id="password" class="w-full py-3 px-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all shadow-sm" placeholder="••••••••" required />
  </div>
  <label for="remember" class="flex items-center mb-5">
    <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" required />
    <p class="ms-2 text-sm font-medium text-heading select-none">I agree with the <a href="#" class="text-fg-brand hover:underline">terms and conditions</a>.</p>
  </label>
  <button type="submit" class="w-full py-3 px-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm shadow-lg shadow-primary-500/30 transition-all transform hover:-translate-y-0.5">Submit</button>
</form>
@foreach ($users as $user)
    <h1>{{ $user->name }}</h1>
@endforeach
</div>
