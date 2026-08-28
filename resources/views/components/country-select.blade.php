@props(['selected' => 'Colombia'])

<select name="country"
    {{ $attributes->merge(['class' => 'w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-600 bg-white text-gray-800']) }}>
    @foreach (['Colombia', 'Perú', 'Ecuador', 'Venezuela', 'Panamá', 'Costa Rica', 'República Dominicana', 'Guatemala', 'Honduras', 'Nicaragua', 'El Salvador', 'México', 'Bolivia', 'Brasil', 'Chile', 'Argentina', 'Uruguay', 'Paraguay', 'Estados Unidos', 'Canadá', 'España', 'Otro'] as $country)
        <option value="{{ $country }}" {{ $selected === $country ? 'selected' : '' }}>
            {{ $country }}
        </option>
    @endforeach
</select>
