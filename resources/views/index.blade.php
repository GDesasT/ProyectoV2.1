@extends('layouts.app')

@section('content')
<div class="bg-cover bg-center" style="background-image: url('../img/comedorbueno.png');">
    <div class="container mx-auto py-20 px-10 animate-fadeInUp">
        <div class="flex flex-col md:flex-row md:space-x-8 items-center">
            <div class="md:w-1/2 flex justify-center animate-fadeInUp">
                <img src="{{ asset('img/logo.jpeg') }}" class="h-64 md:h-1/2 rounded-full" alt="Logo Comedor Industrial">
            </div>
            <div class="md:w-1/2 sm:w-auto bg-black bg-opacity-40 rounded-2xl p-5 m-10 animate-fadeInUp">
                <h1 class="text-3xl font-bold text-center text-white">Conócenos</h1>
                <p class="mt-4 text-gray-300 text-justify leading-relaxed">Comedores de la Fuente es una empresa dedicada a proporcionar servicios de comedor para maquiladoras. Con un enfoque en la calidad, la nutrición y la satisfacción de los empleados, Comedores de la Fuente se especializa en ofrecer comidas equilibradas y deliciosas en un ambiente acogedor. La empresa entiende la importancia de una buena alimentación para el rendimiento y bienestar de los trabajadores, por lo que se esfuerza por utilizar ingredientes frescos y de alta calidad en sus menús diarios.</p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto mt-8">
    <div class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-1 gap-8 animate-fadeInUp">
        <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fadeInUp">
            <img src="{{ asset('img/barradeensaladas.jpg') }}" class="w-full h-64 object-cover" alt="Card Image">
            <div class="p-4">
                <h5 class="text-xl font-bold text-gray-800 mb-2">5 Años de Experiencia</h5>
                <p class="text-gray-600">Con el ánimo de brindar servicios de alimentación a todas aquellas empresas que desean alimentar sanamente a sus colaboradores y clientes.
                    Nuestra especialidad se basa en ofrecer un servicio de diseño, preparación y entrega de comidas nutritivas, deliciosas y variadas que contribuyan a generar hábitos alimenticios que favorezcan la productividad y promuevan la salud.
                </p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fadeInUp">
            <img src="{{ asset('img/generalcomedor.jpg') }}" class="w-full h-64 object-cover" alt="Card Image">
            <div class="p-4">
                <h5 class="text-xl font-bold text-gray-800 mb-2">Calidad de Alimentos</h5>
                <p class="text-gray-600">Comedores de la Fuente es una empresa dedicada a proporcionar servicios de alimentación de la más alta calidad a diversas industrias. Con un firme compromiso hacia la salud y el bienestar, la empresa selecciona cuidadosamente cada ingrediente, garantizando que solo los productos más frescos y nutritivos lleguen a sus comedores. Sus chefs altamente capacitados elaboran menús variados y balanceados, diseñados para satisfacer tanto los gustos como las necesidades nutricionales de los comensales.</p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto mt-8">
    <div class="flex flex-col md:flex-row md:space-x-8 items-center animate-fadeInUp">
        <div class="md:w-1/3 flex justify-center animate-fadeInUp">
            <img src="{{ asset('img/distintivoH.png') }}" class="h-64" alt="Distintivo H">
        </div>
        <div class="md:w-2/3 sm:w-auto bg-white rounded-2xl p-5 m-10 animate-fadeInUp">
            <h2 class="text-3xl font-bold text-center text-gray-800">DISTINTIVO “H”</h2>
            <p class="mt-4 text-gray-600 text-justify leading-relaxed">
                Contamos con el reconocimiento que otorga la Secretaría de Turismo y la Secretaría de Salud a aquellos establecimientos que cumplen con los estándares de higiene que marca la Norma Mexicana NMX-F605 NORMEX 2015. Nuestra propuesta de valor es conseguir, si es el caso, la certificación para el servicio de comedor.
            </p>
            <p class="mt-4 text-gray-600 text-justify leading-relaxed">
                Prestamos especial importancia a la calidad de los alimentos y el servicio a los comensales, además de seleccionar a los mejores proveedores, aquellos que brinden la mejor calidad para su completa satisfacción.
            </p>
        </div>
    </div>
</div>

<div class="container mx-auto mt-8">
    <div class="flex flex-col md:flex-row md:space-x-8 items-center animate-fadeInUp">
        <div class="md:w-2/3 bg-white rounded-2xl p-10 m-10 animate-fadeInUp">
            <h2 class="text-4xl font-bold text-center text-gray-800">CONTACTENOS DIRECTAMENTE</h2>
            <p class="mt-6 text-xl text-gray-600 text-center leading-relaxed">
                TELEFONO: 8711551686
            </p>
            <p class="mt-4 text-xl text-gray-600 text-center leading-relaxed">
                CORREO ELECTRONICO: comedoresdelafuenterg@gmail.com
            </p>
        </div>
        <div class="md:w-1/3 flex justify-center animate-fadeInUp">
            <img src="{{ asset('img/logotelefonoyemail.png') }}" class="h-48" alt="Contacto">
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
