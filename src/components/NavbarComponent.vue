<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

defineProps({
    activeSection: {
        type: String,
        default: 'home'
    }
});

const emit = defineEmits(['cambiarSeccion']);

// Estado para controlar el menú móvil
const mobileMenuOpen = ref(false);

// Función para toggle del menú móvil
const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};

// Función para cambiar sección y cerrar el menú móvil si está abierto
const navegar = (seccion) => {
    emit('cambiarSeccion', seccion);
    if (mobileMenuOpen.value) {
        mobileMenuOpen.value = false;
    }
};

// Función para ir a la página de login
const goToLogin = () => {
    router.push('/login');
};
</script>

<template>
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo y nombre -->
            <div class="navbar-brand">
                <img src="/Logo.png" alt="Logo" class="navbar-logo" />
                <h1 class="navbar-title">LigaXpert</h1>
            </div>

            <!-- Botón para menú móvil -->
            <button class="navbar-toggle" @click="toggleMobileMenu" aria-label="Menu">
                <span class="navbar-toggle-icon"></span>
                <span class="navbar-toggle-icon"></span>
                <span class="navbar-toggle-icon"></span>
            </button>

            <!-- Navegación principal -->
            <div class="navbar-menu" :class="{ 'is-active': mobileMenuOpen }">
                <ul class="navbar-links">
                    <li class="navbar-item">
                        <router-link to="/" class="navbar-link" active-class="is-active">
                            Inicio
                        </router-link>
                    </li>
                    <li class="navbar-item">
                        <router-link to="/torneos" class="navbar-link" active-class="is-active">
                            Torneos
                        </router-link>
                    </li>
                    <li class="navbar-item">
                        <router-link to="/equipos" class="navbar-link" active-class="is-active">
                            Equipos
                        </router-link>
                    </li>
                    <li class="navbar-item">
                        <router-link to="/estadisticas" class="navbar-link" active-class="is-active">
                            Estadísticas
                        </router-link>
                    </li>
                    <li class="navbar-item">
                        <router-link to="/calendario" class="navbar-link" active-class="is-active">
                            Calendario
                        </router-link>
                    </li>
                </ul>

                <!-- Botones de autenticación -->
                <div class="navbar-auth">
                    <button class="btn btn-login" @click="goToLogin">Iniciar Sesión</button>
                    <button class="btn btn-register">Registrarse</button>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar {
    background-color: var(--dark-color);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 100;
    width: 100%;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.navbar-brand {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: inherit;
}

.navbar-logo {
    height: 80px;
    width: auto;
    margin-right: 40px;
}

.navbar-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    color: var(--light-color);
}

.navbar-toggle {
    display: none;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    flex-direction: column;
    justify-content: space-between;
    height: 24px;
}

.navbar-toggle-icon {
    display: block;
    width: 24px;
    height: 2px;
    background-color: var(--light-color);
    transition: all 0.3s ease;
}

.navbar-menu {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex: 1;
    margin-left: 2rem;
}

.navbar-links {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.navbar-item {
    margin: 0 1rem;
}

.navbar-item a {
    color: var(--light-color);
    text-decoration: none;
    font-weight: 500;
    padding: 5px 0;
    position: relative;
    transition: color 0.3s ease;
}

.navbar-item a:hover {
    color: var(--accent-color);
}

.navbar-item a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 3px;
    background-color: var(--accent-color);
    transition: width 0.3s ease;
    border-radius: 1.5px;
}

.navbar-item a:hover::after,
.navbar-item a.is-active::after {
    width: 100%;
}

.navbar-auth {
    display: flex;
    align-items: center;
}

.btn-login {
    background-color: transparent;
    color: var(--accent-color);
    border: 1px solid var(--accent-color);
    margin-right: 10px;
}

.btn-login:hover {
    background-color: var(--accent-color);
    color: var(--dark-color);
}

.btn-register {
    background-color: var(--primary-color);
    color: white;
}

.btn-register:hover {
    background-color: var(--secondary-color);
}

/* Estilos para móvil */
@media (max-width: 768px) {
    .navbar-toggle {
        display: flex;
    }

    .navbar-menu {
        position: absolute;
        top: 70px;
        left: 0;
        width: 100%;
        flex-direction: column;
        background-color: var(--dark-color);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        margin-left: 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-20px);
        transition: all 0.3s ease;
    }

    .navbar-menu.is-active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .navbar-links {
        flex-direction: column;
        width: 100%;
        margin-bottom: 1rem;
    }

    .navbar-item {
        margin: 0.5rem 0;
        width: 100%;
        text-align: center;
    }

    .navbar-auth {
        flex-direction: column;
        width: 100%;
    }

    .btn {
        width: 100%;
        margin: 0.5rem 0;
    }

    .btn-login {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}
</style>