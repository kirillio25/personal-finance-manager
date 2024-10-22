<x-app-layout>
    <div class="py-12">
        <div class="container-fluid">
            <div class="row">

                <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar p-3 shadow-sm">
                    <div class="position-sticky">
                        <h5 class="text-center mb-3">Меню</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2">
                                <a class="nav-link d-flex align-items-center text-dark active" href="#">
                                    <span class="me-2">&#x1F4C8;</span> Транзакции
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                    <x-app-layout>
                        <div id="app">
                            <router-view></router-view> 
                        </div>
                    </x-app-layout>

                    
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                        <h2>Панель управления</h2>
                    </div>

      

                    
                    {{-- Панели --}}
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card mb-4 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="me-3" style="font-size: 2rem;">&#x1F4C8;</span>
                                        <h5 class="card-title mb-0">Транзакции</h5>
                                    </div>
                                    <p class="card-text">Просмотр транзакциий</p>
                                    <router-link to="/transactions" class="btn btn-outline-primary">Посмотреть</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
