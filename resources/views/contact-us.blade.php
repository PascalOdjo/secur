@extends('header')
@section('content')
<main>
    <section class="abt-01">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="seting">
                        <h3>Nous Contacter</h3>
                        <ol>
                            <li>Acceuil <i class="fas fa-chevron-double-right"></i></li>
                            <li>Nous Contacter</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-001">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading">
                        <h2>GET IN TOUCH</h2>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="contact-box">
                        <ul>
                            <li>Agence de Sécurité Security Guards size à Novissi non loin de la station MRS
                                Novissi, Lomé - Togo</li>
                            <li>+228 90 00 00 01</li>
                            <li>securityguards@gmail.com</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="contact-box">
                        <form action="{{route('contact.submit')}}" method="POST" class="my-form">
                            @csrf

                            @include('_message')
                            <div class="form-group">
                                <input type="name" name="nom" class="form-control" placeholder="Nom">
                            </div>

                            <div class="form-group">
                                <input type="text" name="prenom" class="form-control" placeholder="Prénoms">
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="telephone" placeholder="Téléphone">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="adresse" placeholder="Adresse">
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="entreprise" placeholder="Entreprise"></input>
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="nombre_agents" placeholder="Nombre d'agents"></input>
                            </div>

                            <div class="form-group">
                                <textarea name="description" class="form-control" placeholder="Entrer votre message"></textarea>
                            </div>

                            <div class="form-group">
                                <div class="link">
                                    <button type="submit" class="btn btn-primary">Envoyer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
    
@endsection