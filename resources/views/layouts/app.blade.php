<div>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand">
                    <router-link to="/">{{ config('app.name', 'Laravel') }}</router-link>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li>
                        <router-link to="/memoria">Jogar</router-link>
                    </li>
                    <li>
                        <router-link to="/statistics">Statistics</router-link>
                    </li>
                    <li>
                        <router-link to="/example">Example</router-link>
                    </li>
                    <li v-if="admin" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            Administração<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                               <li>
                                    <router-link to="/admin">Admin</router-link>
                                </li>
                                <li>
                                    <router-link to="/users">Utilizadores</router-link>
                                </li>
                                <li>
                                    <router-link to="/example">Imagens do jogo</router-link>
                                </li>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li>
                            <router-link to="/login">
                                <div v-if="loggedIn == false">
                                    Login    
                                </div>
                                <div v-if="loggedIn">
                                    Logout    
                                </div>
                            </router-link>
                        </li>
                        {{--
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        --}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>
