@include('header')

@section('title', 'Requete')
    
@section('name')
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
                            <li>First Floor,Vincent Plaza, Kuzhithurai,Marthandam, Kanyakumari Dist
                                Tamilnadu, India - 629163</li>
                            <li>sales@smarteyeapps.com</li>
                            <li>+91 9751791203</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="contact-box">
                        <form action="{{route('admin.demandes.store')}}" method="POST" class="my-form">
                            @csrf
                            // champ caché de l'id du client
                            <div class="form-group">
                                <input type="hidden" name="client_id" class="form-control" placeholder="Nom" value="{{Auth::user()->id}}">
                            </div>

                            <div class="form-group">
                                <input type="text" name="site" class="form-control" placeholder="Renseignez le site">
                            </div>

                            <div class="form-group">
                                <select name="type_vacation" class="form-control">
                                    <option value="">Sélectionner le type de vacation</option>
                                    <option value="sys_12">Système 12</option>
                                    <option value="sys_08">Système 08</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="number" class="form-control" name="nombre_contrats" placeholder="Nombre de contrats">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="description" placeholder="Description">
                            </div>

                            

                            <div class="form-group">
                                <div class="link">
                                    <button type="submit">Envoyer</button>
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