<nav class="side-nav">
    <ul>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title">
                    Dashboard 
                    <div class="side-menu__sub-icon "> </div>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.contact.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                <div class="side-menu__title">Liên hệ</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="megaphone"></i> </div>
                <div class="side-menu__title">
                    Quảng cáo
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('admin.banners.index') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="layers"></i> </div>
                        <div class="side-menu__title"> Danh sách </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.banners.create') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="plus"></i> </div>
                        <div class="side-menu__title"> Tạo mới </div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- <li class="side-nav__devider my-6"></li> --}}
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="edit"></i> </div>
                <div class="side-menu__title">
                    Khuyến mãi
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('admin.promotion.index') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="layers"></i> </div>
                        <div class="side-menu__title"> Danh sách </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.promotion.create') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="plus"></i> </div>
                        <div class="side-menu__title"> Tạo mới </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.category.index') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="layers"></i> </div>
                        <div class="side-menu__title"> Danh mục </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>