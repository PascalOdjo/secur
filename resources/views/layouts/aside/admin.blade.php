<ul class="vertical-menu">
    <li class="vertical-header">Main</li>
    <li>
        <a href="javaScript:void();">
            <i class="ri-dashboard-line"></i><span>Dashboard</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">
            <li><a href="{{ route('admin.dashboard') }}">Administration</a></li>
            <li><a href="{{ route('logout') }}">logout</a></li>
        </ul>
    </li>
    <li class="vertical-header">Components</li>
    <li>
        <a href="javaScript:void();">
            <i class="ri-server-line"></i>
            <span>Enregistrements</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">
            <li><a href="{{route('admin.demandes.create')}}">Enregistrement</a></li>
            <li><a href="{{route('admin.demandes.index')}}">Liste des enregistrements</a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();">
            <i class="ri-pen-nib-line"></i><span>Gestion des Agents</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">
            <li><a href="{{route('admin.agents.create')}}">Ajouter un Agent</a></li>
            <li><a href="{{route('admin.agents.index')}}">Liste des Agents</a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();">
            <i class="ri-stack-line"></i><span>Vacations</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">                                
            <li><a href="{{route('admin.vacations.create')}}">Créer une Vacation</a></li>  
            <li><a href="{{route('admin.vacations.index')}}">Liste des Vacations</a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();">
            <i class="ri-compass-3-line"></i><span>Sites</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">                                
            <li><a href="{{route('admin.sites.create')}}">Créer un Site</a></li>  
            <li><a href="{{route('admin.sites.index')}}">Liste des Sites</a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();">
            <i class="ri-account-circle-line

"></i><span>Gestion des Clients</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">                                
            <li><a href="{{route('admin.clients.create')}}">Ajouter un Client</a></li>  
            <li><a href="{{route('admin.clients.index')}}">Liste des Clients</a></li>
        </ul>
    </li>
    <li>
        <a href="{{ route('admin.pointages.index') }}">
            <i class="ri-bubble-chart-line"></i><span>Pointages</span><span class="badge badge-success float-right">New</span>
        </a>
    </li>  
    <li>
        <a href="javaScript:void();">
          <i class="ri-apps-line"></i><span>Messages</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">
            <li><a href="apps-calender.html">Agents</a></li>
            <li><a href="apps-chat.html">Clients</a></li> 
            <li>
                <a href="javaScript:void();">Notifications<i class="ri-arrow-right-s-line"></i></a>
                <ul class="vertical-submenu">
                    <li><a href="apps-email-inbox.html">Clients</a></li>
                    <li><a href="apps-email-open.html">Agents</a></li>
                    <li><a href="apps-email-compose.html">Administration</a></li>
                </ul>
            </li>
            
        </ul>
    </li>
    <li>
        <a href="javaScript:void();">
          <i class="ri-todo-line"></i><span>Facturations</span><i class="ri-arrow-right-s-line"></i>
        </a>
        <ul class="vertical-submenu">
            <li><a href="{{route('admin.invoices.create')}}">Clients</a></li> 
            <li><a href="{{route('admin.invoices.create')}}">Agents</a></li>
            
            
        </ul>
    </li>
    
                                            
</ul>