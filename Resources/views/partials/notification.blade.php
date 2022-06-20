<ul class="c-header-nav ml-auto">
    <li class="c-header-nav-item dropdown notifications-menu">
        <a href="#" class="c-header-nav-link" data-toggle="dropdown">
            <i class="far fa-bell color-white"></i>
            @php($alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())
            @if($alertsCount > 0)
            <span class="badge badge-warning navbar-badge">
                {{ $alertsCount }}
            </span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @if(count($alerts = \Auth::user()->userUserAlerts()->withPivot('read')->limit(10)->orderBy('created_at',
            'ASC')->get()->reverse()) > 0)
            @foreach($alerts as $alert)
            <div class="dropdown-item">
                <a href="{{ $alert->alert_link }}" rel="noopener noreferrer">
                    @if($alert->pivot->read === 0)
                    <strong>
                        @endif
                        {{ $alert->alert_text }}
                        @if($alert->pivot->read === 0)
                    </strong>
                    @endif
                </a>
            </div>
            @endforeach
            @else
            <div class="text-center">
                {{ trans('global.no_alerts') }}
            </div>
            @endif
        </div>
    </li>
</ul>