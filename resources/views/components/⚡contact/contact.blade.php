<div class="min-h-screen bg-white dark:bg-[#1D293D] py-16">
    <div class="container mx-auto px-4 max-w-3xl">

        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Contáctanos
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                ¿Tienes dudas, sugerencias o necesitas ayuda? Escríbenos y te responderemos lo antes posible.
            </p>
        </div>

        <form wire:submit.prevent="send" class="space-y-6 bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl p-8 shadow-sm backdrop-blur">

            <div class="grid md:grid-cols-2 gap-6">
                <flux:input wire:model.defer="name" label="Nombre" placeholder="Tu nombre" />
                <flux:input wire:model.defer="email" type="email" label="Correo electrónico" placeholder="correo@ejemplo.com" />
            </div>

            <flux:input wire:model.defer="subject" label="Asunto" placeholder="Motivo de tu mensaje" />

            <flux:textarea wire:model.defer="message" label="Mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." />

            <div class="flex items-center justify-center">
                <flux:button type="submit" variant="primary">
                    Enviar mensaje
                </flux:button>
            </div>

        </form>
    </div>
</div>
