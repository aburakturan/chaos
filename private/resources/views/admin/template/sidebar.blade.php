<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            @if (auth()->user()->can('admin.dashboard.index') || auth()->user()->can('admin.settings.edit'))
                <li class="nav-item start">
                    <a href="javascript:void(0);" class="nav-link nav-toggle">
                        <i class="icon-home"></i>
                        <span class="title">Yönetim Paneli</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        @if (auth()->user()->can('admin.dashboard.index'))
                            <li class="nav-item start">
                                <a href="{{ route('admin.dashboard.index') }}" class="nav-link">
                                    <i class="icon-graph"></i>
                                    <span class="title">Başlangıç</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('admin.settings.edit'))
                            <li class="nav-item start">
                                <a href="{{ route('admin.settings.edit') }}" class="nav-link">
                                    <i class="icon-equalizer"></i>
                                    <span class="title">Ayarlar</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('admin.page.index'))
                <li class="nav-item start">
                    <a href="{{ route('admin.page.index') }}" class="nav-link">
                        <i class="icon-notebook"></i>
                        <span class="title">Sayfalar</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            {{-- Article Resources --}}
            @if (auth()->user()->can('admin.article.index'))
                <li class="nav-item start">
                    <a href="{{ route('admin.article.index') }}" class="nav-link">
                        <i class="icon-notebook"></i>
                        <span class="title">Article Module</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            {{-- Lazanya Resources --}}
            @if (auth()->user()->can('admin.lazanya.index'))
                <li class="nav-item start">
                    <a href="{{ route('admin.lazanya.index') }}" class="nav-link">
                        <i class="icon-notebook"></i>
                        <span class="title">Lazanya Module</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            {{-- Category Resources --}}
            @if (auth()->user()->can('admin.category.index'))
                <li class="nav-item start">
                    <a href="{{ route('admin.category.index') }}" class="nav-link">
                        <i class="icon-notebook"></i>
                        <span class="title">Category Module</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            {{--INNER_PART_FOR_STUB_GENERATION_DONT_DELETE--}}

            @if (auth()->user()->can('admin.sentence.index'))
                <li class="nav-item start">
                    <a href="{{ route('admin.sentence.index') }}" class="nav-link">
                        <i class="icon-star"></i>
                        <span class="title">Cümleler</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->can('admin.user.index') || auth()->user()->can('admin.role.index') || auth()->user()->can('admin.permission.index'))
                <li class="nav-item start">
                    <a href="javascript:void(0);" class="nav-link nav-toggle">
                        <i class="icon-users"></i>
                        <span class="title">Kullanıcı Yönetimi</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        @if(auth()->user()->can('admin.user.index'))
                            <li class="nav-item start">
                                <a href="{{ route('admin.user.index') }}" class="nav-link">
                                    <i class="icon-user"></i>
                                    <span class="title">Kullanıcılar</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->can('admin.role.index'))
                            <li class="nav-item start">
                                <a href="{{ route('admin.role.index') }}" class="nav-link">
                                    <i class="icon-users"></i>
                                    <span class="title">Roller</span>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->can('admin.permission.index'))
                            <li class="nav-item start">
                                <a href="{{ route('admin.permission.index') }}" class="nav-link">
                                    <i class="icon-layers"></i>
                                    <span class="title">Yetkiler</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('admin.error-log.index'))
                <li class="nav-item start">
                    <a target="_blank" href="{{ route('admin.error-log.index') }}" class="nav-link">
                        <i class="icon-chemistry"></i>
                        <span class="title">Günlük Geçmişi</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->can('admin.activity-log.index'))
                <li class="nav-item start">
                    <a href="{{ route('admin.activity-log.index') }}" class="nav-link">
                        <i class="icon-eyeglasses"></i>
                        <span class="title">Etkinlik Kayıtları</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
