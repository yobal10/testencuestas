<x-layouts::auth.split title="Iniciar sesión">
    <div class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
        <div class="text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                <x-app-logo-icon class="h-7 w-7 fill-current" />
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Bienvenido</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Accede a tu panel universitario</p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/40 dark:bg-red-500/10 dark:text-red-200">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Correo electrónico</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                    placeholder="admin@example.com"
                >
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center justify-between gap-3 text-sm">
                <label class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-300">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Recordarme
                </label>

                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-500/30">
                Iniciar sesión
            </button>
        </form>

        <div class="flex items-center justify-center gap-2 border-t border-slate-200 pt-4 text-sm text-slate-600 dark:border-slate-700 dark:text-slate-300">
            <span>¿No tienes una cuenta?</span>
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Crear nueva cuenta</a>
        </div>
    </div>
</x-layouts::auth.split>