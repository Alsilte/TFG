<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import NavbarComponent from '../components/NavbarComponent.vue';
import FooterComponent from '../components/FooterComponent.vue';

const router = useRouter();
const activeSection = ref('profile');

// Verificar autenticación al montar el componente
onMounted(() => {
    const isAuthenticated = localStorage.getItem('isAuthenticated');
    if (!isAuthenticated) {
        router.push('/login');
    }
});

// Función para cerrar sesión
const logout = () => {
    localStorage.removeItem('isAuthenticated');
    localStorage.removeItem('userRole');
    router.push('/login');
};
</script>

<template>
    <div class="user-layout">
        <!-- Barra de navegación -->
        <NavbarComponent :activeSection="activeSection" />

        <!-- Contenido principal -->
        <main class="user-content">
            <div class="content-container">
                <div class="user-sidebar">
                    <div class="user-info">
                        <div class="user-avatar">👤</div>
                        <h3 class="user-name">Usuario Normal</h3>
                        <span class="user-status">Cuenta activa</span>
                    </div>

                    <nav class="sidebar-nav">
                        <ul class="user-menu">
                            <li>
                                <router-link to="/user/profile" class="user-menu-link"
                                    :class="{ active: activeSection === 'profile' }">
                                    <span class="menu-icon">👤</span>
                                    <span>Mi Perfil</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/user/tournaments" class="user-menu-link"
                                    :class="{ active: activeSection === 'tournaments' }">
                                    <span class="menu-icon">🏆</span>
                                    <span>Mis Torneos</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/user/teams" class="user-menu-link"
                                    :class="{ active: activeSection === 'teams' }">
                                    <span class="menu-icon">👥</span>
                                    <span>Mis Equipos</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/user/matches" class="user-menu-link"
                                    :class="{ active: activeSection === 'matches' }">
                                    <span class="menu-icon">⚽</span>
                                    <span>Mis Partidos</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/user/statistics" class="user-menu-link"
                                    :class="{ active: activeSection === 'statistics' }">
                                    <span class="menu-icon">📊</span>
                                    <span>Mis Estadísticas</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>

                    <div class="sidebar-footer">
                        <button @click="logout" class="logout-button">
                            <span class="menu-icon">🚪</span>
                            <span>Cerrar Sesión</span>
                        </button>
                    </div>
                </div>

                <div class="user-main-content">
                    <router-view />
                </div>
            </div>
        </main>

        <!-- Pie de página -->
        <FooterComponent />
    </div>
</template>

<style scoped>
/* Estilos para el layout de usuario */
.user-layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.user-content {
    flex: 1;
    background-color: #F2EB85;
    padding: 2rem 0;
}

.content-container {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    gap: 2rem;
    padding: 0 2rem;
}

.user-sidebar {
    width: 280px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(38, 38, 38, 0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: sticky;
    top: 100px;
    height: fit-content;
}

.user-info {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    background: linear-gradient(135deg, #818C30 0%, #6A7327 100%);
    color: #F2EB85;
    position: relative;
}

.user-avatar {
    width: 80px;
    height: 80px;
    background-color: white;
    color: #818C30;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 10px rgba(38, 38, 38, 0.15);
    border: 3px solid #F2EB85;
}

.user-name {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.user-status {
    font-size: 0.8rem;
    background-color: rgba(242, 235, 133, 0.2);
    padding: 0.2rem 0.8rem;
    border-radius: 20px;
    margin-top: 0.5rem;
}

.sidebar-nav {
    padding: 1.5rem 0;
    flex: 1;
}

.user-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.user-menu li {
    margin-bottom: 0.3rem;
}

.user-menu-link {
    display: flex;
    align-items: center;
    padding: 0.8rem 1.5rem;
    text-decoration: none;
    color: #262626;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.user-menu-link:hover {
    background-color: rgba(129, 140, 48, 0.08);
    color: #818C30;
}

.user-menu-link.active {
    background-color: rgba(129, 140, 48, 0.12);
    color: #818C30;
    border-left-color: #818C30;
}

.menu-icon {
    margin-right: 10px;
    font-size: 1.1rem;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid #f1f2f3;
}

.logout-button {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 0.8rem 1rem;
    background-color: rgba(38, 38, 38, 0.1);
    color: #262626;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 0.95rem;
}

.logout-button:hover {
    background-color: rgba(38, 38, 38, 0.2);
    color: #262626;
}

.user-main-content {
    flex: 1;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(38, 38, 38, 0.1);
    padding: 2rem;
    min-height: 600px;
}

/* Responsive */
@media (max-width: 992px) {
    .content-container {
        flex-direction: column;
    }

    .user-sidebar {
        width: 100%;
        position: static;
    }
}

@media (max-width: 768px) {
    .user-content {
        padding: 1rem 0;
    }

    .content-container {
        padding: 0 1rem;
    }

    .user-main-content {
        padding: 1.5rem;
    }
}
</style>