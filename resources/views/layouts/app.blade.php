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
                        <router-link to="/replay">Replay</router-link>
                    </li>
                    <li>
                        <router-link to="/statistics">Statistics</router-link>
                    </li>
                    <!--
                    <li v-if="admin" class="dropdown">
                    -->
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
                                    <router-link to="/images">Imagens do jogo</router-link>
                                </li>
                                <li>
                                    <router-link to="/example">Estatisticas</router-link>
                                </li>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li v-if="!loggedIn">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            Autenticação <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <router-link to="/login">
                                    <div>
                                        Login    
                                    </div>
                                </router-link>
                                <router-link to="/signup">
                                    <div>
                                        Registo   
                                    </div>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-else class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            @{{loggedUser != null ? loggedUser.name : 'utilizador'}} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <router-link to="/edit">
                                    <div>
                                        Dashboard (editar dados)
                                    </div>
                                </router-link>
                                <router-link to="/login">
                                    <div>
                                        Logout    
                                    </div>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
