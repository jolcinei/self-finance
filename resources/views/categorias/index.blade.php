<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('categorias.store') }}">
            @csrf
            <select wire:model.lazy="categoria.parent_id" name="parent_id" id="parent_id" class="form-control">
                <option value="">--Categoria Pai--</option>
                @foreach ($categorias as $value => $label)
                <option value="{{$value}}">
                    {{$label->nome}}
                </option>
                @endforeach
            </select>
            <select wire:model.lazy="categoria.operacao" name="operacao" id="operacao" error="categoria.operacao" placeholder="Escolha a Operação">
                <option value="" disabled>Escolha a Operação</option>
                @foreach(\App\Enums\CategoriaOperacaoEnum::values() as $key=>$value)
                <option value="{{ $key }}">
                    {{ $value }}
                </option>
                @endforeach
            </select>
            <input type="text" name="nome" placeholder="{{ __('Nome da categoria?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('nome') }}</text>
            <textarea name="descricao" placeholder="{{ __('Descrição da categoria?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('descricao') }}</textarea>
            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Adicionar') }}</x-primary-button>
        </form>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

            <table class="table table-sm table-dark">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Operação</th>
                        <th>Categoria PAI</th>
                        <th>User</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nome }}</td>
                        <td>{{ $categoria->operacao }}</td>
                        <td>{{ $categoria->parent_id }}</td>
                        <td>{{ $categoria->user->name }} -
                            <small class="ml-2 text-sm text-gray-600">{{ $categoria->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($categoria->created_at->eq($categoria->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </td>
                        <td>
                            @if ($categoria->user->is(auth()->user()))
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('categorias.edit', $categoria)">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('categorias.destroy', $categoria) }}">
                                        @csrf
                                        @method('delete')
                                        <x-dropdown-link :href="route('categorias.destroy', $categoria)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                            @endif
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>