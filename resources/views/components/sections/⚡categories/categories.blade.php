<section class="mx-auto max-w-7xl px-6 py-12 bg-muted/30">
    <div class="text-center mb-10">
        <h2 class="text-2xl lg:text-3xl font-bold mb-2">
            Explora por Categoría
        </h2>
        <p class="text-muted-foreground">
            Encuentra encuestas según tu interés
        </p>
    </div>

    @php
        $rows = [
            $categories->slice(0, 5),
            $categories->slice(5, 4),
            $categories->slice(9, 3),
        ];
    @endphp

    <div class="flex flex-col items-center gap-4">
        @foreach($rows as $row)
            @if($row->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach($row as $category)
                        <flux:button
                            wire:key="category-{{ $category->id }}"
                            href="{{ route('categories.show', $category->slug) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 whitespace-normal text-left">

                            <span class="break-words">
                                {{ $category->name }}
                            </span>
                        </flux:button>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>

    <div class="mt-10 text-center">
        <flux:button
            type="button"
            href="{{ route('categories') }}"
            wire:navigate
            variant="primary">
            Ver más categorías
        </flux:button>
    </div>
</section>
