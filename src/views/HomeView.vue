<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import NavbarComponent from '../components/NavbarComponent.vue';
import FooterComponent from '../components/FooterComponent.vue';

const route = useRoute();

// Computar si estamos en una ruta administrativa
const isAdminRoute = computed(() => {
    return route.path.startsWith('/admin');
});

// Estado para controlar la sección activa
const activeSection = computed(() => {
    // Obtener la ruta actual y establecer la sección activa
    const path = route.path;
    if (path === '/') return 'home';
    if (path.includes('/torneos')) return 'torneos';
    if (path.includes('/equipos')) return 'equipos';
    if (path.includes('/estadisticas')) return 'estadisticas';
    if (path.includes('/calendario')) return 'calendario';
    return 'home';
});

// Datos de ejemplo para mostrar torneos activos
const torneos = [
    {
        id: 1,
        nombre: 'Liga Municipal 2025',
        deporte: 'Fútbol',
        estado: 'En curso',
        equipos: 12,
        fechaInicio: '15/03/2025',
        fechaFin: '30/05/2025'
    },
    {
        id: 2,
        nombre: 'Copa Regional Élite',
        deporte: 'Baloncesto',
        estado: 'Inscripción abierta',
        equipos: 8,
        fechaInicio: '10/05/2025',
        fechaFin: '25/06/2025'
    },
    {
        id: 3,
        nombre: 'Torneo Intercolegial',
        deporte: 'Voleibol',
        estado: 'Próximamente',
        equipos: 16,
        fechaInicio: '01/06/2025',
        fechaFin: '15/07/2025'
    }
];

// Datos de ejemplo para mostrar próximos partidos
const proximosPartidos = [
    {
        id: 1,
        local: 'Atlético Norte',
        visitante: 'Deportivo Sur',
        fecha: '15/04/2025',
        hora: '18:00',
        lugar: 'Estadio Municipal'
    },
    {
        id: 2,
        local: 'Estrellas FC',
        visitante: 'Real Oeste',
        fecha: '16/04/2025',
        hora: '19:30',
        lugar: 'Polideportivo Central'
    },
    {
        id: 3,
        local: 'Halcones BC',
        visitante: 'Águilas Doradas',
        fecha: '17/04/2025',
        hora: '20:00',
        lugar: 'Pabellón Cubierto'
    }
];
</script>

<template>
    <!-- Usar router-view si es una ruta administrativa -->
    <router-view v-if="isAdminRoute" />

    <!-- Mostrar la estructura normal de la aplicación si no es admin -->
    <div v-else class="app-container">
        <!-- Barra de navegación -->
        <NavbarComponent :activeSection="activeSection" />

        <!-- Contenido principal -->
        <main>
            <!-- Hero Section -->
            <section v-if="activeSection === 'home'" class="hero-section">
                <div class="hero-content">
                    <h1>Sistema de Gestión de Torneos Deportivos</h1>
                    <p>Organiza, administra y sigue tus torneos deportivos de manera integral en una sola plataforma</p>
                    <div class="hero-buttons">
                        <button class="btn btn-primary">Crear Torneo</button>
                        <button class="btn btn-secondary">Explorar Torneos</button>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="image-placeholder">
                        <!-- Imagen de portada -->
                    </div>
                </div>
            </section>

            <!-- Sección de Torneos Activos -->
            <section v-if="activeSection === 'home' || activeSection === 'torneos'" class="torneos-section">
                <h2>Torneos Activos</h2>
                <div class="torneos-grid">
                    <div v-for="torneo in torneos" :key="torneo.id" class="torneo-card">
                        <div class="torneo-header">
                            <h3>{{ torneo.nombre }}</h3>
                            <span class="badge"
                                :class="torneo.estado === 'En curso' ? 'badge-success' : 'badge-primary'">
                                {{ torneo.estado }}
                            </span>
                        </div>
                        <div class="torneo-body">
                            <p><strong>Deporte:</strong> {{ torneo.deporte }}</p>
                            <p><strong>Equipos:</strong> {{ torneo.equipos }}</p>
                            <p><strong>Inicio:</strong> {{ torneo.fechaInicio }}</p>
                            <p><strong>Fin:</strong> {{ torneo.fechaFin }}</p>
                        </div>
                        <div class="torneo-footer">
                            <button class="btn btn-sm">Ver detalles</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección de Próximos Partidos -->
            <section v-if="activeSection === 'home' || activeSection === 'calendario'" class="partidos-section">
                <h2>Próximos Partidos</h2>
                <div class="partidos-container">
                    <div v-for="partido in proximosPartidos" :key="partido.id" class="partido-card">
                        <div class="partido-fecha">
                            <span>{{ partido.fecha }}</span>
                            <span>{{ partido.hora }}</span>
                        </div>
                        <div class="partido-equipos">
                            <div class="equipo local">
                                <span class="equipo-nombre">{{ partido.local }}</span>
                            </div>
                            <div class="versus">VS</div>
                            <div class="equipo visitante">
                                <span class="equipo-nombre">{{ partido.visitante }}</span>
                            </div>
                        </div>
                        <div class="partido-info">
                            <span>{{ partido.lugar }}</span>
                            <button class="btn btn-sm">Detalles</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Otras secciones (equipos, estadísticas) se pueden añadir de manera similar -->
            <section v-if="activeSection === 'equipos'" class="equipos-section">
                <h2>Equipos Registrados</h2>
                <p>Contenido de equipos en desarrollo...</p>
            </section>

            <section v-if="activeSection === 'estadisticas'" class="estadisticas-section">
                <h2>Estadísticas</h2>
                <p>Contenido de estadísticas en desarrollo...</p>
            </section>

            <!-- Características principales -->
            <section v-if="activeSection === 'home'" class="features-section">
                <h2>Características Principales</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Gestión Completa</h3>
                        <p>Crea y configura diferentes formatos de competición (liga, copa, grupos)</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">👥</div>
                        <h3>Registro de Participantes</h3>
                        <p>Sistema de inscripción para clubes/equipos y jugadores</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📅</div>
                        <h3>Planificación</h3>
                        <p>Programa partidos y visualiza calendario de encuentros</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">⏱️</div>
                        <h3>Tiempo Real</h3>
                        <p>Módulo de arbitraje para control de partidos en vivo</p>
                    </div>
                </div>
            </section>
        </main>

        <!-- Pie de página -->
        <FooterComponent />
    </div>
</template>

<style>
/* Estilos no-scoped para el contenedor principal */
.app-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    max-width: 100%;
    margin: 0;
    padding: 0;
}
</style>

<style scoped>
/* Estilos específicos del componente */
.logo {
    height: 40px;
    margin-right: 10px;
}

.logo-sm {
    height: 30px;
    margin-right: 5px;
}

main {
    flex: 1;
    padding: 0;
    width: 100%;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Hero Section */
.hero-section {
    display: flex;
    align-items: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, var(--light-color) 0%, var(--accent-color) 100%);
    min-height: 500px;
    width: 100%;
}

.hero-content {
    flex: 1;
    padding-right: 2rem;
}

.hero-content h1 {
    font-size: 2.8rem;
    margin-bottom: 1.5rem;
    color: var(--dark-color);
}

.hero-content p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: var(--dark-color);
    max-width: 600px;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
}

.hero-image {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-placeholder {
    width: 100%;
    max-width: 500px;
    height: 300px;
    background-color: var(--light-color);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
}

/* Torneos Section */
.torneos-section,
.partidos-section,
.features-section {
    padding: 3rem 2rem;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.torneos-section h2,
.partidos-section h2,
.features-section h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: var(--dark-color);
}

.torneos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.torneo-card {
    background-color: #fff;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.torneo-card:hover {
    transform: translateY(-5px);
}

.torneo-header {
    padding: 1rem;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.torneo-header h3 {
    margin: 0;
    font-size: 1.2rem;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.badge-success {
    background-color: var(--secondary-color);
    color: white;
}

.badge-primary {
    background-color: var(--primary-color);
    color: white;
}

.torneo-body {
    padding: 1rem;
}

.torneo-body p {
    margin: 0.5rem 0;
}

.torneo-footer {
    padding: 1rem;
    background-color: var(--light-color);
    text-align: right;
}

/* Partidos Section */
.partidos-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.partido-card {
    background-color: #fff;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 1rem;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
    border-left: 4px solid var(--primary-color);
}

.partido-card:hover {
    transform: translateY(-5px);
}

.partido-fecha {
    display: flex;
    justify-content: space-between;
    color: var(--dark-color);
    font-weight: 500;
    margin-bottom: 1rem;
}

.partido-equipos {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.equipo {
    flex: 1;
    text-align: center;
}

.equipo-nombre {
    font-weight: 500;
    font-size: 1.1rem;
}

.versus {
    margin: 0 1rem;
    font-weight: bold;
    color: var(--primary-color);
}

.partido-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--primary-color);
}

/* Features Section */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.feature-card {
    background-color: #fff;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s ease;
    border-top: 4px solid var(--primary-color);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.feature-card h3 {
    margin-bottom: 1rem;
    color: var(--dark-color);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section {
        flex-direction: column;
        padding: 2rem 1rem;
    }

    .hero-content {
        padding-right: 0;
        margin-bottom: 2rem;
        text-align: center;
    }

    .hero-buttons {
        justify-content: center;
    }
}
</style>