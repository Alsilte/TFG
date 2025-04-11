<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const activeSection = ref('dashboard');

// Verificar autenticación al montar el componente
onMounted(() => {
    const isAuthenticated = localStorage.getItem('isAuthenticated');
    if (!isAuthenticated) {
        router.push('/login');
    }
});

// Función para cambiar la sección activa
const changeSection = (section) => {
    activeSection.value = section;
};

// Función para cerrar sesión
const logout = () => {
    localStorage.removeItem('isAuthenticated');
    router.push('/login');
};
</script>

<template>
    <div class="admin-layout">
        <!-- Sidebar de navegación -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="/Logo.png" alt="Logo" class="sidebar-logo" />
                <h1 class="sidebar-title">LigaXpert</h1>
            </div>

            <nav class="sidebar-nav">
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <router-link to="/admin/dashboard" class="sidebar-link"
                            :class="{ active: activeSection === 'dashboard' }" @click="changeSection('dashboard')">
                            <span class="sidebar-icon">📊</span>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li class="sidebar-item">
                        <router-link to="/admin/torneos" class="sidebar-link"
                            :class="{ active: activeSection === 'torneos' }" @click="changeSection('torneos')">
                            <span class="sidebar-icon">🏆</span>
                            <span>Torneos</span>
                        </router-link>
                    </li>
                    <li class="sidebar-item">
                        <router-link to="/admin/equipos" class="sidebar-link"
                            :class="{ active: activeSection === 'equipos' }" @click="changeSection('equipos')">
                            <span class="sidebar-icon">👥</span>
                            <span>Equipos</span>
                        </router-link>
                    </li>
                    <li class="sidebar-item">
                        <router-link to="/admin/partidos" class="sidebar-link"
                            :class="{ active: activeSection === 'partidos' }" @click="changeSection('partidos')">
                            <span class="sidebar-icon">⚽</span>
                            <span>Partidos</span>
                        </router-link>
                    </li>
                    <li class="sidebar-item">
                        <router-link to="/admin/jugadores" class="sidebar-link"
                            :class="{ active: activeSection === 'jugadores' }" @click="changeSection('jugadores')">
                            <span class="sidebar-icon">🏃</span>
                            <span>Jugadores</span>
                        </router-link>
                    </li>
                    <li class="sidebar-item">
                        <router-link to="/admin/estadisticas" class="sidebar-link"
                            :class="{ active: activeSection === 'estadisticas' }"
                            @click="changeSection('estadisticas')">
                            <span class="sidebar-icon">📈</span>
                            <span>Estadísticas</span>
                        </router-link>
                    </li>
                    <li class="sidebar-item">
                        <router-link to="/admin/configuracion" class="sidebar-link"
                            :class="{ active: activeSection === 'configuracion' }"
                            @click="changeSection('configuracion')">
                            <span class="sidebar-icon">⚙️</span>
                            <span>Configuración</span>
                        </router-link>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <button @click="logout" class="logout-button">
                    <span class="sidebar-icon">🚪</span>
                    <span>Cerrar Sesión</span>
                </button>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="admin-content">
            <!-- Header del contenido -->
            <header class="content-header">
                <div class="header-left">
                    <h1>Panel de Administración</h1>
                </div>
                <div class="header-right">
                    <div class="admin-profile">
                        <span class="admin-name">Administrador</span>
                        <div class="avatar">👤</div>
                    </div>
                </div>
            </header>

            <!-- Área de contenido donde se renderizarán los componentes -->
            <div class="content-area">
                <router-view />
            </div>
        </main>
    </div>
</template>

<style scoped>
.admin-layout {
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.admin-sidebar {
    width: 260px;
    background-color: var(--dark-color);
    color: var(--light-color);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 100;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar-header {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-logo {
    height: 40px;
    width: auto;
    margin-right: 10px;
}

.sidebar-title {
    font-size: 1.2rem;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: var(--light-color);
}

.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 0;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-item {
    margin-bottom: 0.3rem;
}

.sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.8rem 1.5rem;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s;
}

.sidebar-link:hover,
.sidebar-link.active {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
}

.sidebar-icon {
    margin-right: 10px;
    font-size: 1.2rem;
}

.sidebar-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.logout-button {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 0.8rem;
    background-color: rgba(231, 76, 60, 0.2);
    color: var(--light-color);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.logout-button:hover {
    background-color: rgba(231, 76, 60, 0.3);
}

/* Contenido principal */
.admin-content {
    flex: 1;
    margin-left: 260px;
    background-color: #f5f7fa;
    min-height: 100vh;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.header-left h1 {
    margin: 0;
    font-size: 1.5rem;
    color: var(--dark-color);
}

.admin-profile {
    display: flex;
    align-items: center;
}

.admin-name {
    margin-right: 1rem;
    font-weight: 500;
}

.avatar {
    width: 40px;
    height: 40px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.content-area {
    padding: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-sidebar {
        width: 70px;
        overflow: hidden;
    }

    .sidebar-title {
        display: none;
    }

    .sidebar-link span:not(.sidebar-icon) {
        display: none;
    }

    .sidebar-icon {
        margin-right: 0;
        font-size: 1.5rem;
    }

    .admin-content {
        margin-left: 70px;
    }

    .logout-button span:not(.sidebar-icon) {
        display: none;
    }
}
</style>