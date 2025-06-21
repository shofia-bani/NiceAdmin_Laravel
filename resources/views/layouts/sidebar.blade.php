<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{url('/admin/dashboard')}}">
                <i class="bi bi-grid">
                    <span>
                        Dashboard
                    </span>
                </i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('students.index')}}">
                <i class="bi bi-people">
                    <span>
                        Student
                    </span>
                </i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('books')}}">
                <i class="bi bi-card-list">
                    <span>
                        Penyewaan Book
                    </span>
                </i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('product.index')}}">
                <i class="bi bi-book">
                    <span>
                        Product                       
                    </span>
                </i>
            </a>
        </li>
    </ul>
</aside>