<li class="{{ isActiveRoute('back.quizzes-package.*') }}">
    <a href="#"><i class="fa fa-list-ol"></i> <span class="nav-label">Тесты</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        @include('admin.module.quizzes-package.quizzes::back.includes.package_navigation')
        @include('admin.module.quizzes-package.tags::back.includes.package_navigation')
    </ul>
</li>
