<script setup>
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// Props para integración con el resto de la aplicación
defineProps({
    activeView: {
        type: String,
        default: 'overview'
    }
});

const emit = defineEmits(['changeView']);

// Estado para las vistas del dashboard
const activeCard = ref('overview');

// Función para cambiar entre vistas del dashboard
const changeActiveCard = (card) => {
    activeCard.value = card;
    emit('changeView', card);
};

// Datos para tableros informativos
const infoCards = ref([
    {
        id: 'tournaments',
        title: 'Torneos Activos',
        value: 5,
        change: '+2',
        icon: '🏆',
        color: 'primary'
    },
    {
        id: 'teams',
        title: 'Equipos Registrados',
        value: 32,
        change: '+8',
        icon: '👥',
        color: 'success'
    },
    {
        id: 'matches',
        title: 'Partidos Jugados',
        value: 64,
        change: '+12',
        icon: '⚽',
        color: 'warning'
    },
    {
        id: 'players',
        title: 'Jugadores Activos',
        value: 248,
        change: '+15',
        icon: '🏃',
        color: 'info'
    }
]);

// Datos para torneos recientes
const recentTournaments = ref([
    {
        id: 1,
        name: 'Liga Municipal 2025',
        sport: 'Fútbol',
        startDate: '15/03/2025',
        teams: 12,
        status: 'En progreso',
        progress: 65
    },
    {
        id: 2,
        name: 'Copa Regional Élite',
        sport: 'Baloncesto',
        startDate: '10/05/2025',
        teams: 8,
        status: 'Inscripción',
        progress: 25
    },
    {
        id: 3,
        name: 'Torneo Intercolegial',
        sport: 'Voleibol',
        startDate: '01/06/2025',
        teams: 16,
        status: 'Planificación',
        progress: 10
    }
]);

// Datos para próximos partidos
const upcomingMatches = ref([
    {
        id: 1,
        tournament: 'Liga Municipal 2025',
        homeTeam: 'Atlético Norte',
        awayTeam: 'Deportivo Sur',
        date: '15/04/2025',
        time: '18:00',
        location: 'Estadio Municipal'
    },
    {
        id: 2,
        tournament: 'Liga Municipal 2025',
        homeTeam: 'Estrellas FC',
        awayTeam: 'Real Oeste',
        date: '16/04/2025',
        time: '19:30',
        location: 'Polideportivo Central'
    },
    {
        id: 3,
        tournament: 'Copa Regional Élite',
        homeTeam: 'Halcones BC',
        awayTeam: 'Águilas Doradas',
        date: '17/04/2025',
        time: '20:00',
        location: 'Pabellón Cubierto'
    }
]);

// Datos para notificaciones recientes
const recentNotifications = ref([
    {
        id: 1,
        type: 'success',
        message: 'Nuevo equipo registrado: Real Oeste',
        time: 'hace 2 horas',
        icon: '🏆'
    },
    {
        id: 2,
        type: 'info',
        message: 'Partido finalizado: Atlético Norte 2 - 1 Deportivo Este',
        time: 'hace 5 horas',
        icon: '⚽'
    },
    {
        id: 3,
        type: 'warning',
        message: 'Plazo de inscripción: Copa Regional Élite cierra en 3 días',
        time: 'hace 12 horas',
        icon: '⏰'
    },
    {
        id: 4,
        type: 'error',
        message: 'Partido suspendido: Halcones BC vs Panteras por mal tiempo',
        time: 'hace 1 día',
        icon: '🚫'
    }
]);

// Datos para actividades recientes
const recentActivities = ref([
    {
        id: 1,
        user: 'Admin',
        action: 'Creó un nuevo torneo',
        target: 'Torneo Intercolegial',
        time: 'hace 3 horas'
    },
    {
        id: 2,
        user: 'Juan Pérez',
        action: 'Registró un nuevo equipo',
        target: 'Estrellas FC',
        time: 'hace 8 horas'
    },
    {
        id: 3,
        user: 'Árbitro Martínez',
        action: 'Finalizó un partido',
        target: 'Atlético Norte vs Deportivo Este',
        time: 'hace 5 horas'
    },
    {
        id: 4,
        user: 'María García',
        action: 'Actualizó información del equipo',
        target: 'Halcones BC',
        time: 'hace 1 día'
    }
]);

// Datos para las tareas pendientes
const pendingTasks = ref([
    {
        id: 1,
        task: 'Revisar inscripciones de Liga Municipal',
        priority: 'Alta',
        dueDate: '12/04/2025',
        status: 'Pendiente'
    },
    {
        id: 2,
        task: 'Asignar árbitros para la jornada del fin de semana',
        priority: 'Alta',
        dueDate: '13/04/2025',
        status: 'En progreso'
    },
    {
        id: 3,
        task: 'Finalizar calendario de Copa Regional',
        priority: 'Media',
        dueDate: '18/04/2025',
        status: 'Pendiente'
    },
    {
        id: 4,
        task: 'Actualizar reglamento de Torneo Intercolegial',
        priority: 'Baja',
        dueDate: '25/04/2025',
        status: 'Pendiente'
    }
]);

// Referencias para gráficos
const participationChart = ref(null);
const sportsDistributionChart = ref(null);

// Función para inicializar gráficos
onMounted(() => {
    // Gráfico de Participación Mensual
    if (participationChart.value) {
        new Chart(participationChart.value, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Equipos',
                        data: [12, 18, 24, 32, 38, 42],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Jugadores',
                        data: [95, 120, 156, 198, 220, 248],
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Evolución de Participación 2025'
                    }
                }
            }
        });
    }

    // Gráfico de Distribución por Deportes
    if (sportsDistributionChart.value) {
        new Chart(sportsDistributionChart.value, {
            type: 'doughnut',
            data: {
                labels: ['Fútbol', 'Baloncesto', 'Voleibol', 'Tenis', 'Otros'],
                datasets: [{
                    label: 'Torneos por Deporte',
                    data: [45, 25, 15, 10, 5],
                    backgroundColor: [
                        '#3498db',
                        '#2ecc71',
                        '#e74c3c',
                        '#f1c40f',
                        '#9b59b6'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Distribución por Deportes'
                    }
                }
            }
        });
    }
});

// Funciones para acciones rápidas
const createNewTournament = () => {
    alert('Funcionalidad: Crear nuevo torneo');
};

const addNewTeam = () => {
    alert('Funcionalidad: Añadir nuevo equipo');
};

const scheduledMatch = () => {
    alert('Funcionalidad: Programar partido');
};

const generateReport = () => {
    alert('Funcionalidad: Generar informe');
};
</script>

<template>
    <div class="dashboard-container">
        <!-- Encabezado del Dashboard -->
        <div class="dashboard-header">
            <div class="dashboard-title">
                <h1>Panel de Administración</h1>
                <p>Bienvenido al centro de control de torneos deportivos</p>
            </div>
            <div class="dashboard-actions">
                <button class="btn btn-primary">
                    <span>+ Nuevo Torneo</span>
                </button>
            </div>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="info-cards">
            <div v-for="card in infoCards" :key="card.id" class="info-card" :class="`info-card-${card.color}`">
                <div class="info-card-icon">
                    <span>{{ card.icon }}</span>
                </div>
                <div class="info-card-content">
                    <h3>{{ card.title }}</h3>
                    <div class="info-card-value">
                        <span class="value">{{ card.value }}</span>
                        <span class="change">{{ card.change }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección principal del Dashboard -->
        <div class="dashboard-content">
            <!-- Controles de navegación -->
            <div class="dashboard-tabs">
                <button @click="changeActiveCard('overview')" :class="{ active: activeCard === 'overview' }"
                    class="dashboard-tab">
                    Resumen
                </button>
                <button @click="changeActiveCard('tournaments')" :class="{ active: activeCard === 'tournaments' }"
                    class="dashboard-tab">
                    Torneos
                </button>
                <button @click="changeActiveCard('teams')" :class="{ active: activeCard === 'teams' }"
                    class="dashboard-tab">
                    Equipos
                </button>
                <button @click="changeActiveCard('matches')" :class="{ active: activeCard === 'matches' }"
                    class="dashboard-tab">
                    Partidos
                </button>
                <button @click="changeActiveCard('stats')" :class="{ active: activeCard === 'stats' }"
                    class="dashboard-tab">
                    Estadísticas
                </button>
            </div>

            <!-- Vista Principal - Resumen -->
            <div v-if="activeCard === 'overview'" class="dashboard-view">
                <div class="dashboard-section">
                    <div class="dashboard-section-header">
                        <h2>Acciones Rápidas</h2>
                    </div>
                    <div class="quick-actions">
                        <button @click="createNewTournament" class="quick-action-btn">
                            <span class="action-icon">🏆</span>
                            <span class="action-text">Crear Torneo</span>
                        </button>
                        <button @click="addNewTeam" class="quick-action-btn">
                            <span class="action-icon">👥</span>
                            <span class="action-text">Añadir Equipo</span>
                        </button>
                        <button @click="scheduledMatch" class="quick-action-btn">
                            <span class="action-icon">📅</span>
                            <span class="action-text">Programar Partido</span>
                        </button>
                        <button @click="generateReport" class="quick-action-btn">
                            <span class="action-icon">📊</span>
                            <span class="action-text">Generar Informe</span>
                        </button>
                    </div>
                </div>

                <!-- Sección de gráficos -->
                <div class="dashboard-charts">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Participación Mensual</h3>
                        </div>
                        <div class="chart-body">
                            <canvas ref="participationChart" height="250"></canvas>
                        </div>
                    </div>
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Distribución por Deportes</h3>
                        </div>
                        <div class="chart-body">
                            <canvas ref="sportsDistributionChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Sección inferior con torneos y partidos recientes -->
                <div class="dashboard-bottom-section">
                    <div class="dashboard-card recent-tournaments">
                        <div class="card-header">
                            <h3>Torneos Recientes</h3>
                            <button class="btn-link">Ver todos</button>
                        </div>
                        <div class="card-body">
                            <div v-for="tournament in recentTournaments" :key="tournament.id"
                                class="recent-tournament-item">
                                <div class="tournament-info">
                                    <div class="tournament-name">
                                        <h4>{{ tournament.name }}</h4>
                                        <span class="tournament-sport">{{ tournament.sport }}</span>
                                    </div>
                                    <div class="tournament-details">
                                        <span>{{ tournament.teams }} equipos | {{ tournament.startDate }}</span>
                                        <span class="status-badge"
                                            :class="`status-${tournament.status.toLowerCase().replace(' ', '-')}`">
                                            {{ tournament.status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="tournament-progress">
                                    <div class="progress-bar">
                                        <div class="progress" :style="`width: ${tournament.progress}%`"></div>
                                    </div>
                                    <span class="progress-text">{{ tournament.progress }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card upcoming-matches">
                        <div class="card-header">
                            <h3>Próximos Partidos</h3>
                            <button class="btn-link">Ver todos</button>
                        </div>
                        <div class="card-body">
                            <div v-for="match in upcomingMatches" :key="match.id" class="upcoming-match-item">
                                <div class="match-tournament">{{ match.tournament }}</div>
                                <div class="match-teams">
                                    <span class="team home-team">{{ match.homeTeam }}</span>
                                    <span class="vs">vs</span>
                                    <span class="team away-team">{{ match.awayTeam }}</span>
                                </div>
                                <div class="match-details">
                                    <div class="match-date">
                                        <span class="icon">📅</span>
                                        <span>{{ match.date }}</span>
                                    </div>
                                    <div class="match-time">
                                        <span class="icon">⏰</span>
                                        <span>{{ match.time }}</span>
                                    </div>
                                    <div class="match-location">
                                        <span class="icon">📍</span>
                                        <span>{{ match.location }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de actividades y notificaciones -->
                <div class="dashboard-bottom-section">
                    <div class="dashboard-card recent-activities">
                        <div class="card-header">
                            <h3>Actividades Recientes</h3>
                            <button class="btn-link">Ver todas</button>
                        </div>
                        <div class="card-body">
                            <div v-for="activity in recentActivities" :key="activity.id" class="activity-item">
                                <div class="activity-content">
                                    <div class="activity-text">
                                        <strong>{{ activity.user }}</strong> {{ activity.action }}: <span
                                            class="activity-target">{{ activity.target }}</span>
                                    </div>
                                    <div class="activity-time">{{ activity.time }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card notifications">
                        <div class="card-header">
                            <h3>Notificaciones</h3>
                            <button class="btn-link">Ver todas</button>
                        </div>
                        <div class="card-body">
                            <div v-for="notification in recentNotifications" :key="notification.id"
                                class="notification-item" :class="`notification-${notification.type}`">
                                <div class="notification-icon">{{ notification.icon }}</div>
                                <div class="notification-content">
                                    <div class="notification-message">{{ notification.message }}</div>
                                    <div class="notification-time">{{ notification.time }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de tareas pendientes -->
                <div class="dashboard-section">
                    <div class="dashboard-card pending-tasks">
                        <div class="card-header">
                            <h3>Tareas Pendientes</h3>
                            <button class="btn-link">Añadir tarea</button>
                        </div>
                        <div class="card-body">
                            <table class="tasks-table">
                                <thead>
                                    <tr>
                                        <th>Tarea</th>
                                        <th>Prioridad</th>
                                        <th>Fecha Límite</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="task in pendingTasks" :key="task.id">
                                        <td>{{ task.task }}</td>
                                        <td>
                                            <span class="priority-badge"
                                                :class="`priority-${task.priority.toLowerCase()}`">
                                                {{ task.priority }}
                                            </span>
                                        </td>
                                        <td>{{ task.dueDate }}</td>
                                        <td>
                                            <span class="status-badge"
                                                :class="`status-${task.status.toLowerCase().replace(' ', '-')}`">
                                                {{ task.status }}
                                            </span>
                                        </td>
                                        <td class="actions-cell">
                                            <button class="icon-btn" title="Editar">✏️</button>
                                            <button class="icon-btn" title="Completar">✅</button>
                                            <button class="icon-btn" title="Eliminar">❌</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vista de Torneos -->
            <div v-else-if="activeCard === 'tournaments'" class="dashboard-view">
                <div class="view-placeholder">
                    <h2>Gestión de Torneos</h2>
                    <p>Aquí podrás administrar todos los torneos deportivos.</p>
                    <p>Contenido en desarrollo...</p>
                </div>
            </div>

            <!-- Vista de Equipos -->
            <div v-else-if="activeCard === 'teams'" class="dashboard-view">
                <div class="view-placeholder">
                    <h2>Gestión de Equipos</h2>
                    <p>Administra los equipos inscritos en los diferentes torneos.</p>
                    <p>Contenido en desarrollo...</p>
                </div>
            </div>

            <!-- Vista de Partidos -->
            <div v-else-if="activeCard === 'matches'" class="dashboard-view">
                <div class="view-placeholder">
                    <h2>Gestión de Partidos</h2>
                    <p>Programa y gestiona los partidos de tus torneos.</p>
                    <p>Contenido en desarrollo...</p>
                </div>
            </div>

            <!-- Vista de Estadísticas -->
            <div v-else-if="activeCard === 'stats'" class="dashboard-view">
                <div class="view-placeholder">
                    <h2>Estadísticas Detalladas</h2>
                    <p>Visualiza estadísticas completas de torneos, equipos y jugadores.</p>
                    <p>Contenido en desarrollo...</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Variables CSS para mantener consistencia con el resto de la aplicación */
:root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --accent-color: #f1c40f;
    --dark-color: #34495e;
    --light-color: #ecf0f1;
    --success-color: #2ecc71;
    --warning-color: #f39c12;
    --danger-color: #e74c3c;
    --info-color: #3498db;
    --border-radius: 8px;
    --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
}

/* Estilos del Dashboard */
.dashboard-container {
    padding: 1.5rem;
    width: 100%;
    max-width: 100%;
    background-color: #f5f7fa;
    min-height: calc(100vh - 160px);
    /* Ajustar según la altura del navbar y footer */
}

/* Encabezado del Dashboard */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.dashboard-title h1 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.dashboard-title p {
    color: #7f8c8d;
    margin: 0;
}

.dashboard-actions {
    display: flex;
    gap: 1rem;
}

/* Tarjetas informativas */
.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.info-card {
    display: flex;
    align-items: center;
    background-color: white;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    box-shadow: var(--box-shadow);
    transition: transform 0.3s ease;
    border-left: 4px solid var(--primary-color);
}

.info-card:hover {
    transform: translateY(-5px);
}

.info-card-primary {
    border-left-color: var(--primary-color);
}

.info-card-success {
    border-left-color: var(--success-color);
}

.info-card-warning {
    border-left-color: var(--warning-color);
}

.info-card-info {
    border-left-color: var(--info-color);
}

.info-card-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: rgba(52, 152, 219, 0.1);
    margin-right: 1rem;
    font-size: 1.5rem;
}

.info-card-content h3 {
    font-size: 0.9rem;
    color: #7f8c8d;
    margin-top: 0;
    margin-bottom: 0.5rem;
}

.info-card-value {
    display: flex;
    align-items: baseline;
}

.info-card-value .value {
    font-size: 1.8rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-right: 0.5rem;
}

.info-card-value .change {
    font-size: 0.9rem;
    color: var(--success-color);
}

/* Contenido principal del Dashboard */
.dashboard-content {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
}

/* Pestañas del Dashboard */
.dashboard-tabs {
    display: flex;
    background-color: var(--dark-color);
    overflow-x: auto;
    padding: 0 1rem;
}

.dashboard-tab {
    padding: 1rem 1.5rem;
    color: rgba(255, 255, 255, 0.7);
    background: transparent;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    white-space: nowrap;
}

.dashboard-tab:hover {
    color: white;
}

.dashboard-tab.active {
    color: white;
}

.dashboard-tab.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: var(--accent-color);
}

/* Vista del Dashboard */
.dashboard-view {
    padding: 1.5rem;
}

/* Sección de acciones rápidas */
.dashboard-section {
    margin-bottom: 2rem;
}

.dashboard-section-header {
    margin-bottom: 1rem;
}

.dashboard-section-header h2 {
    font-size: 1.3rem;
    color: var(--dark-color);
    margin: 0;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
}

.quick-action-btn:hover {
    background-color: #e9ecef;
    transform: translateY(-3px);
}

.action-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.action-text {
    font-weight: 500;
    color: var(--dark-color);
}

/* Estilos para gráficos */
.dashboard-charts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.chart-card {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.chart-header {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.chart-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: var(--dark-color);
}

.chart-body {
    padding: 1rem;
    height: 250px;
}

/* Sección inferior con widgets */
.dashboard-bottom-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.dashboard-card {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.card-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: var(--dark-color);
}

.btn-link {
    background: none;
    border: none;
    color: var(--primary-color);
    cursor: pointer;
    padding: 0;
    font-size: 0.9rem;
    text-decoration: none;
    transition: var(--transition);
}

.btn-link:hover {
    color: var(--secondary-color);
    text-decoration: underline;
}

.card-body {
    padding: 1rem;
}

/* Estilos para widgets de torneos recientes */
.recent-tournament-item {
    padding: 1rem;
    border-bottom: 1px solid #f1f2f3;
}

.recent-tournament-item:last-child {
    border-bottom: none;
}

.tournament-info {
    margin-bottom: 0.8rem;
}

.tournament-name {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.3rem;
}

.tournament-name h4 {
    margin: 0;
    font-size: 1rem;
    color: var(--dark-color);
}

.tournament-sport {
    font-size: 0.8rem;
    color: #7f8c8d;
    background-color: #f8f9fa;
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
}

.tournament-details {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #7f8c8d;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
    font-weight: 500;
}

.status-en-progreso {
    background-color: rgba(46, 204, 113, 0.1);
    color: var(--success-color);
}

.status-inscripción {
    background-color: rgba(52, 152, 219, 0.1);
    color: var(--primary-color);
}

.status-planificación {
    background-color: rgba(243, 156, 18, 0.1);
    color: var(--warning-color);
}

.status-pendiente {
    background-color: rgba(52, 73, 94, 0.1);
    color: var(--dark-color);
}

.tournament-progress {
    display: flex;
    align-items: center;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background-color: #f1f2f3;
    border-radius: 4px;
    overflow: hidden;
    margin-right: 10px;
}

.progress {
    height: 100%;
    background-color: var(--success-color);
    border-radius: 4px;
}

.progress-text {
    font-size: 0.75rem;
    color: var(--dark-color);
    font-weight: 500;
}

/* Estilos para próximos partidos */
.upcoming-match-item {
    padding: 1rem;
    border-bottom: 1px solid #f1f2f3;
}

.upcoming-match-item:last-child {
    border-bottom: none;
}

.match-tournament {
    font-size: 0.8rem;
    color: #7f8c8d;
    margin-bottom: 0.5rem;
}

.match-teams {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.8rem;
}

.team {
    font-weight: 500;
    font-size: 1rem;
    color: var(--dark-color);
}

.vs {
    font-size: 0.9rem;
    color: #7f8c8d;
    margin: 0 0.5rem;
}

.match-details {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.85rem;
    color: #7f8c8d;
}

.match-date,
.match-time,
.match-location {
    display: flex;
    align-items: center;
}

.icon {
    margin-right: 0.3rem;
}

/* Estilos para actividades recientes */
.activity-item {
    padding: 0.8rem 1rem;
    border-bottom: 1px solid #f1f2f3;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-content {
    display: flex;
    flex-direction: column;
}

.activity-text {
    margin-bottom: 0.3rem;
    font-size: 0.9rem;
}

.activity-target {
    color: var(--primary-color);
}

.activity-time {
    font-size: 0.8rem;
    color: #95a5a6;
}

/* Estilos para notificaciones */
.notification-item {
    display: flex;
    padding: 1rem;
    border-bottom: 1px solid #f1f2f3;
    border-left: 4px solid transparent;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-success {
    border-left-color: var(--success-color);
}

.notification-info {
    border-left-color: var(--info-color);
}

.notification-warning {
    border-left-color: var(--warning-color);
}

.notification-error {
    border-left-color: var(--danger-color);
}

.notification-icon {
    margin-right: 1rem;
    font-size: 1.2rem;
}

.notification-content {
    flex: 1;
}

.notification-message {
    margin-bottom: 0.3rem;
    font-size: 0.9rem;
}

.notification-time {
    font-size: 0.8rem;
    color: #95a5a6;
}

/* Estilos para las tareas pendientes */
.tasks-table {
    width: 100%;
    border-collapse: collapse;
}

.tasks-table th,
.tasks-table td {
    padding: 0.8rem;
    text-align: left;
    border-bottom: 1px solid #f1f2f3;
}

.tasks-table th {
    font-weight: 600;
    color: var(--dark-color);
    background-color: #f8f9fa;
}

.priority-badge {
    font-size: 0.75rem;
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
}

.priority-alta {
    background-color: rgba(231, 76, 60, 0.1);
    color: var(--danger-color);
}

.priority-media {
    background-color: rgba(243, 156, 18, 0.1);
    color: var(--warning-color);
}

.priority-baja {
    background-color: rgba(52, 152, 219, 0.1);
    color: var(--info-color);
}

.status-en-progreso {
    background-color: rgba(52, 152, 219, 0.1);
    color: var(--info-color);
}

.actions-cell {
    white-space: nowrap;
}

.icon-btn {
    background: none;
    border: none;
    font-size: 1rem;
    cursor: pointer;
    padding: 0.3rem;
    margin-right: 0.3rem;
    transition: transform 0.2s ease;
}

.icon-btn:hover {
    transform: scale(1.2);
}

/* Vista placeholder para secciones en desarrollo */
.view-placeholder {
    text-align: center;
    padding: 3rem;
    color: #7f8c8d;
}

.view-placeholder h2 {
    color: var(--dark-color);
    margin-bottom: 1rem;
}

/* Estilos responsive */
@media (max-width: 992px) {

    .dashboard-charts,
    .dashboard-bottom-section {
        grid-template-columns: 1fr;
    }

    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .dashboard-title {
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .info-cards {
        grid-template-columns: 1fr;
    }

    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }

    .dashboard-tabs {
        padding: 0;
    }

    .dashboard-tab {
        padding: 1rem 0.8rem;
        font-size: 0.9rem;
    }

    .tournament-name,
    .tournament-details {
        flex-direction: column;
        align-items: flex-start;
    }

    .tournament-name h4 {
        margin-bottom: 0.5rem;
    }

    .match-teams {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }

    .match-details {
        flex-direction: column;
        gap: 0.5rem;
    }

    .tasks-table {
        display: block;
        overflow-x: auto;
    }
}

@media (max-width: 480px) {
    .quick-actions {
        grid-template-columns: 1fr;
    }

    .dashboard-tab {
        font-size: 0.8rem;
        padding: 0.8rem 0.5rem;
    }
}
</style>