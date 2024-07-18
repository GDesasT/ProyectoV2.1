@extends('layouts.app')

@section('content')

<div class="bg-cover bg-center" style="background-image: url('../img/comedorbueno.png');">
    <div class="container mx-auto py-20 px-20">
        <div class="flex flex-col md:flex-row md:space-x-8 items-center">
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('img/logo.jpeg') }}" class="h-64 rounded-full" alt="Logo Comedor Industrial">
            </div>
            <div class="md:w-1/2 sm:w-auto bg-black bg-opacity-40 rounded-2xl p-5 m-10">
                <h1 class="text-3xl font-bold text-center text-white">Comedor Industrial</h1>
                <p class="mt-4  text-gray-300 text-justify leading-relaxed">Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sapiente, ipsum, recusandae ab itaque eaque esse blanditiis quo ut fugiat expedita reiciendis iure ipsa molestiae minus porro dolorum exercitationem qui beatae facilis cumque id facere. Modi debitis rerum consequuntur doloremque deleniti tempora praesentium velit? Adipisci nobis obcaecati, iure earum qui officia a minima at hic pariatur explicabo nulla nisi sed quis autem tenetur itaque, non ex unde perspiciatis odit. Cum architecto saepe adipisci ullam laudantium neque officiis asperiores odit praesentium.</p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto mt-8">
    <div class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-1 gap-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('img/comedorbueno.png') }}" class="w-full h-64 object-cover" alt="Card Image">
            <div class="p-4">
                <h5 class="text-xl font-bold text-gray-800 mb-2">Card title</h5>
                <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. In sapiente, enim, nulla unde facilis accusantium fugit alias nam atque quia voluptates rem quam porro impedit necessitatibus placeat incidunt molestias inventore?</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('img/comedorbueno.png') }}" class="w-full h-64 object-cover" alt="Card Image">
            <div class="p-4">
                <h5 class="text-xl font-bold text-gray-800 mb-2">Card title</h5>
                <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias, inventore reiciendis itaque voluptate facilis quos distinctio quisquam aperiam nesciunt ipsa reprehenderit natus nulla placeat repellendus sapiente corporis ratione dolores optio.</p>
            </div>
        </div>
    </div>
</div>

@endsection
