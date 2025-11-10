@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Nuestra Historia</h2>
    <p>CR Mantenimiento & Obra Civil nació con el propósito de ofrecer soluciones integrales en mantenimiento y construcción. A lo largo de los años, hemos trabajado con pasión, compromiso y excelencia.</p>
    <img src="{{ asset('images/historia.jpg') }}" alt="Historia de la empresa" class="img-fluid">
</section>

<section class="section">
    <div class="container">
        <h2>Experiencias de Nuestros Clientes</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial">
                    <p>"Excelente servicio, muy profesionales y atentos a cada detalle. ¡Recomendados!"</p>
                    <strong>- Laura G.</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial">
                    <p>"Gracias a CR, nuestra obra se completó a tiempo y con gran calidad. ¡Muy satisfechos!"</p>
                    <strong>- Carlos M.</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial">
                    <p>"El equipo fue muy amable y resolvieron todas nuestras dudas. ¡Volveremos a contratarlos!"</p>
                    <strong>- Diana R.</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section form-section">
    <div class="container">
        <h2 class="text-center">Solicita tu Cotización</h2>
        <p class="text-center">Déjanos tus datos y uno de nuestros asesores se pondrá en contacto contigo.</p>

        <form action="{{ route('contacto.enviar') }}" method="POST" class="col-md-8 mx-auto">
            @csrf
            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre completo" required>
            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
            <input type="tel" name="telefono" class="form-control" placeholder="Número de contacto" required>
            <textarea name="mensaje" class="form-control" rows="4" placeholder="Cuéntanos qué necesitas..." required></textarea>
            <button type="submit" class="btn btn-primary w-100">Enviar solicitud</button>
        </form>

        <div class="text-center mt-4">
            <a href="https://wa.me/573001234567?text=Hola%20CR%20Mantenimiento,%20quisiera%20una%20cotización" target="_blank">
                Cotizar por WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- *** CÓDIGO HTML DEL BOTÓN FLOTANTE: Aparece solo aquí *** -->
<a href="https://wa.me/573001234567?text=Hola%20CR%20Mantenimiento,%20quisiera%20una%20cotización" class="whatsapp-float" target="_blank" aria-label="Contactar por WhatsApp">
    <i class="fab fa-whatsapp whatsapp-icon"></i>
</a>
<!-- NOTA: Asegúrate de reemplazar 573001234567 con tu número real sin el '+' -->

@endsection