<x-layout>
    <x-slot:title>Página Principal</x-slot:title>

    <!-- Header -->
    <header style="background-image: url('img/header.jpg');">
    <div class="container-fluid full-height">
    <div class="row w-100">
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <div class="jumbotron text-center">
                <h1>NovelSunrise</h1>
                <p>Tus novelas favoritas en un sólo lugar</p>

            </div>
        </div>
    </div>
</div>
</header>


<!-- Sección de Categorías -->
<section id="categorias" class="text-center">
    <h2 style="justify-content: center; margin-bottom: 02em;">Categorías</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
            
                    <img src="img/1.jpg" alt="Japonesas" class="img-fluid">
                    <p>Japonesas</p>
            
            </div>
            <div class="col-md-3 col-sm-6">

                    <img src="img/2.jpg" alt="Coreanas" class="img-fluid">
                    <p>Coreanas</p>

            </div>
            <div class="col-md-3 col-sm-6">

                    <img src="img/3.jpg" alt="Chinas" class="img-fluid">
                    <p>Chinas</p>
            </div>
            <div class="col-md-3 col-sm-6">

                    <img src="img/4.jpg" alt="Varios" class="img-fluid">
                    <p>Varias</p>

            </div>
        </div>
    </div>
</section>

<!-- Sección "Sobre nosotros" -->
<section id="sobre-nosotros" class="py-5">
    <div class="container">
        <div class="row no-gutters">
            <!-- Primera columna con la imagen -->
            <div class="col-md-6 d-flex justify-content-center align-items-center mb-3">
                <img src="img/nosotros.jpg" alt="Sobre Nosotros" class="img-fluid">
            </div>
            <!-- Segunda columna con el contenido -->
            <div class="col-md-6 mt-5">
                <h2>Sobre Nosotros</h2>
                <p>En NovelSunrise, nos apasiona compartir nuestras traducciones de novelas coreanas, chinas y japonesas con una comunidad de lectores ávidos de romance y fantasía. Somos un grupo de entusiastas dedicados a llevar las emocionantes historias de Asia a un público global, ofreciendo una amplia gama de novelas ligeras para tu disfrute.</p>

                <a class="btn-link" href="{{ route('about') }}">Leer más</a>
            </div>
        </div>
    </div>
</section>

</x-layout>