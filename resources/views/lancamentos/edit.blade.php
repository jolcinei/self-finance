<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('lancamentos.update', $lancamento) }}">
            @csrf
            @method('patch')
            <select name="categoria_id" id="categoria_id" class="form-control">
                @foreach ($categorias as $key => $value)
                <option value="{{ $value->id }}" @if ($value->id == $lancamento->categoria_id)
                    selected="selected"
                    @endif
                    >{{ $value->nome }}
                </option>
                @endforeach
            </select>

            <input type="number" step="any" name="valor" value="{{ $lancamento->valor }}" placeholder="{{ __('Valor?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
            <input type="date" name="data_referencia" value="{{ $lancamento->data_referencia }}" placeholder="{{ __('Mês ano do lançamento?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
            <textarea name="comentario" placeholder="{{ __('Comentário?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('comentario', $lancamento->comentario) }}</textarea>
            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('categorias.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>