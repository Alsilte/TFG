// En router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import LoginComponent from '../components/LoginComponent.vue';
import AdminLayout from '../layouts/AdminLayout.vue';
import UserLayout from '../layouts/UserLayout.vue';
import DashboardComponent from '../components/DashboardComponent.vue';
import UserProfileComponent from '../components/UserProfileComponent.vue';

// Componente simple para página no autorizada
const UnauthorizedComponent = {
    template: `
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f5f7fa; padding: 2rem;">
      <div style="text-align: center; background-color: white; padding: 3rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); max-width: 500px;">
        <div style="font-size: 5rem; margin-bottom: 1.5rem;">🔒</div>
        <h1 style="margin-bottom: 1rem;">Acceso No Autorizado</h1>
        <p style="margin-bottom: 2rem; color: #7f8c8d;">No tienes permiso para acceder a esta página.</p>
        <div>
          <button @click="$router.push('/')" class="btn btn-primary" style="margin-right: 1rem;">Ir al inicio</button>
          <button @click="$router.go(-1)" class="btn btn-secondary">Volver atrás</button>
        </div>
      </div>
    </div>
  `
};

// Placeholder para componentes en desarrollo
const PlaceholderComponent = {
    template: `
    <div class="placeholder">
      <h2>Página en Desarrollo</h2>
      <p>Esta sección está actualmente en desarrollo.</p>
    </div>
  `,
};

// Función para verificar autenticación de administrador
const requireAdmin = (to, from, next) => {
    const isAuthenticated = localStorage.getItem('isAuthenticated');
    const userRole = localStorage.getItem('userRole');

    if (!isAuthenticated) {
        next('/login');
    } else if (userRole !== 'admin') {
        next('/unauthorized');
    } else {
        next();
    }
};

// En router/index.js
// Función para verificar autenticación de usuario normal
const requireAuth = (to, from, next) => {
    const isAuthenticated = localStorage.getItem('isAuthenticated');
    const userRole = localStorage.getItem('userRole');
    
    if (!isAuthenticated) {
      next('/login');
    } else if (userRole !== 'user' && userRole !== 'admin') {
      // Si no es usuario ni admin, redirigir a no autorizado
      next('/unauthorized');
    } else {
      next();
    }
  };

const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeView
    },
    {
        path: '/login',
        name: 'Login',
        component: LoginComponent
    },
    {
        path: '/unauthorized',
        name: 'Unauthorized',
        component: UnauthorizedComponent
    },
    // Rutas para administradores
    {
        path: '/admin',
        component: AdminLayout,
        beforeEnter: requireAdmin,
        children: [
            {
                path: 'dashboard',
                name: 'AdminDashboard',
                component: DashboardComponent
            },
            {
                path: 'torneos',
                name: 'AdminTorneos',
                component: PlaceholderComponent
            },
            {
                path: 'equipos',
                name: 'AdminEquipos',
                component: PlaceholderComponent
            },
            {
                path: 'partidos',
                name: 'AdminPartidos',
                component: PlaceholderComponent
            },
            {
                path: 'jugadores',
                name: 'AdminJugadores',
                component: PlaceholderComponent
            },
            {
                path: 'estadisticas',
                name: 'AdminEstadisticas',
                component: PlaceholderComponent
            },
            {
                path: 'configuracion',
                name: 'AdminConfiguracion',
                component: PlaceholderComponent
            },
            // Redireccionar /admin a /admin/dashboard
            {
                path: '',
                redirect: 'dashboard'
            }
        ]
    },
    // Rutas para usuarios normales
    {
        path: '/user',
        component: UserLayout,
        beforeEnter: requireAuth,
        children: [
            {
                path: 'profile',
                name: 'UserProfile',
                component: UserProfileComponent
            },
            {
                path: 'tournaments',
                name: 'UserTournaments',
                component: PlaceholderComponent
            },
            {
                path: 'teams',
                name: 'UserTeams',
                component: PlaceholderComponent
            },
            {
                path: 'matches',
                name: 'UserMatches',
                component: PlaceholderComponent
            },
            {
                path: 'statistics',
                name: 'UserStatistics',
                component: PlaceholderComponent
            },
            // Redireccionar /user a /user/profile
            {
                path: '',
                redirect: 'profile'
            }
        ]
    },
    // Ruta para capturar cualquier otra ruta no definida y redirigir al inicio
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Middleware global para gestionar metadatos y transiciones
router.beforeEach((to, from, next) => {
    document.title = to.name ? `LigaXpert - ${to.name}` : 'LigaXpert';
    next();
});

export default router;