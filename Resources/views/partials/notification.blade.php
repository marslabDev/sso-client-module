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
            <div class="dropdown-item {{ $alert->pivot->read ? 'font-weight-bold' : '' }}">
                @if($alert->alert_link)
                <a href="{{ $alert->alert_link }}" rel="noopener noreferrer">
                    {{ $alert->alert_text }}
                </a>
                @else
                {{ $alert->alert_text }}
                @endif
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
@section('scripts')
@parent
<script>
    $(document).ready(function () {
        $(".notifications-menu").on('click', function () {
            if (!$(this).hasClass('open')) {
                $('.notifications-menu .label-warning').hide();
                $('.notifications-menu .badge-warning').hide();
                $.get("{{ route('sso.user-alerts.read') }}");
            }
        });
    });
</script>
@endsection
