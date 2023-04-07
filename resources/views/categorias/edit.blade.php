<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('categorias.update', $categoria) }}">
            @csrf
            @method('patch')
            <select name="parent_id" id="parent_id" class="form-control">
                @if($categoria->parent_id == null)
                <option value="">--Categoria Pai--</option>
                @endif
                @foreach ($categorias as $key => $value)
                <option value="{{ $value->id }}" @if ($value->id == $categoria->parent_id)
                    selected="selected"
                    @endif
                    >{{ $value->nome }}
                </option>

                @endforeach
            </select>
            <select wire:model.lazy="categoria.operacao" name="operacao" id="operacao" error="categoria.operacao" placeholder="Escolha a Operação">

                <option value="{{$categoria->operacao}}">{{ old('operacao', $categoria->operacao)}}</option>
                @foreach(\App\Enums\CategoriaOperacaoEnum::values() as $key=>$value)
                <option value="{{ $key }}">
                    {{ $value }}
                </option>
                @endforeach
            </select>
            <input type="text" name="nome" value="{{ $categoria->nome }}" placeholder="{{ __('Nome da categoria?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
            <textarea name="descricao" placeholder="{{ __('Descrição da categoria?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('descricao', $categoria->descricao) }}</textarea>
            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('categorias.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>