<script setup>
// Si necesitas añadir variables reactivas o métodos, puedes hacerlo aquí
import { ref } from 'vue';

// Año actual para el copyright
const currentYear = new Date().getFullYear();

// Enlaces del footer
const quickLinks = [
    { name: 'Inicio', path: '#' },
    { name: 'Torneos', path: '#torneos' },
    { name: 'Equipos', path: '#equipos' },
    { name: 'Estadísticas', path: '#estadisticas' },
    { name: 'Calendario', path: '#calendario' },
    { name: 'Contacto', path: '#contacto' }
];

const resourceLinks = [
    { name: 'Guía de Uso', path: '#' },
    { name: 'FAQ', path: '#' },
    { name: 'Soporte', path: '#' },
    { name: 'API', path: '#' }
];

// Redes sociales
const socialLinks = [
    { name: 'Facebook', icon: '📘', path: '#' },
    { name: 'Twitter', icon: '🐦', path: '#' },
    { name: 'Instagram', icon: '📸', path: '#' },
    { name: 'YouTube', icon: '📹', path: '#' }
];

// Función para suscribirse al newsletter
const email = ref('');
const subscribeMessage = ref('');

const subscribe = () => {
    if (email.value && validateEmail(email.value)) {
        subscribeMessage.value = '¡Gracias por suscribirte!';
        email.value = '';
        setTimeout(() => {
            subscribeMessage.value = '';
        }, 3000);
    } else {
        subscribeMessage.value = 'Por favor, ingresa un email válido';
    }
};

// Validar email
const validateEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
};
</script>

<template>
    <footer class="footer">
        <div class="footer-container">
            <!-- Sección superior del footer -->
            <div class="footer-top">
                <!-- Columna de información -->
                <div class="footer-info">
                    <div class="footer-logo">
                        <img src="/Logo.png" alt="Logo" class="footer-logo-img" />
                        <span class="footer-logo-text">LigaXpert</span>
                    </div>
                    <p class="footer-description">
                        Plataforma integral para la gestión de torneos deportivos. Organiza,
                        administra y sigue tus competiciones de manera eficiente.
                    </p>
                    <div class="footer-social">
                        <a v-for="(social, index) in socialLinks" :key="index" :href="social.path" class="social-link"
                            target="_blank" :aria-label="social.name">
                            <span class="social-icon">{{ social.icon }}</span>
                        </a>
                    </div>
                </div>

                <!-- Columna de enlaces rápidos -->
                <div class="footer-links">
                    <h3 class="footer-heading">Enlaces Rápidos</h3>
                    <ul class="footer-links-list">
                        <li v-for="(link, index) in quickLinks" :key="index">
                            <a :href="link.path">{{ link.name }}</a>
                        </li>
                    </ul>
                </div>

                <!-- Columna de recursos -->
                <div class="footer-links">
                    <h3 class="footer-heading">Recursos</h3>
                    <ul class="footer-links-list">
                        <li v-for="(link, index) in resourceLinks" :key="index">
                            <a :href="link.path">{{ link.name }}</a>
                        </li>
                    </ul>
                </div>

                <!-- Columna de newsletter -->
                <div class="footer-newsletter">
                    <h3 class="footer-heading">Mantente Informado</h3>
                    <p>Suscríbete para recibir las últimas noticias y actualizaciones.</p>
                    <form @submit.prevent="subscribe" class="newsletter-form">
                        <input type="email" v-model="email" placeholder="Tu correo electrónico" required
                            class="newsletter-input">
                        <button type="submit" class="newsletter-button">Suscribirse</button>
                    </form>
                    <p v-if="subscribeMessage" class="newsletter-message">{{ subscribeMessage }}</p>
                </div>
            </div>

            <!-- Línea divisoria -->
            <div class="footer-divider"></div>

            <!-- Sección inferior del footer -->
            <div class="footer-bottom">
                <p class="copyright">
                    © {{ currentYear }} LigaXpert - Sistema de Gestión de Torneos Deportivos. Todos los derechos
                    reservados.
                </p>
                <div class="footer-legal">
                    <a href="#" class="legal-link">Términos y Condiciones</a>
                    <a href="#" class="legal-link">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
.footer {
    background-color: var(--dark-color);
    color: var(--light-color);
    padding: 3rem 0 1.5rem;
    width: 100%;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.footer-top {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-info {
    display: flex;
    flex-direction: column;
}

.footer-logo {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.footer-logo-img {
    height: 80px;
    width: auto;
    margin-right: 10px;
}

.footer-logo-text {
    font-size: 1.5rem;
    font-weight: 600;
    color: #fff;
}

.footer-description {
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
    line-height: 1.6;
    color: #bdc3c7;
}

.footer-social {
    display: flex;
    gap: 1rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #34495e;
    color: #ecf0f1;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.social-link:hover {
    background-color: var(--primary-color);
    transform: translateY(-3px);
}

.social-icon {
    font-size: 1.25rem;
}

.footer-heading {
    font-size: 1.2rem;
    margin-bottom: 1.2rem;
    color: #fff;
    position: relative;
    padding-bottom: 0.5rem;
}

.footer-heading::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background-color: var(--primary-color);
    border-radius: 1.5px;
}

.footer-links-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links-list li {
    margin-bottom: 0.75rem;
}

.footer-links-list a {
    color: #bdc3c7;
    text-decoration: none;
    transition: color 0.3s ease, padding-left 0.3s ease;
    display: inline-block;
}

.footer-links-list a:hover {
    color: var(--accent-color);
    padding-left: 5px;
}

.newsletter-form {
    display: flex;
    margin-bottom: 1rem;
}

.newsletter-input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 4px 0 0 4px;
    font-size: 0.9rem;
}

.newsletter-input:focus {
    outline: none;
}

.newsletter-button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 0 4px 4px 0;
    padding: 0 1.25rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: 500;
}

.newsletter-button:hover {
    background-color: var(--secondary-color);
}

.newsletter-message {
    font-size: 0.9rem;
    margin-top: 0.5rem;
    color: #2ecc71;
}

.footer-divider {
    height: 1px;
    background-color: rgba(236, 240, 241, 0.1);
    margin: 1.5rem 0;
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.copyright {
    font-size: 0.9rem;
    color: #95a5a6;
    margin: 0;
}

.footer-legal {
    display: flex;
    gap: 1.5rem;
}

.legal-link {
    color: #95a5a6;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.legal-link:hover {
    color: var(--accent-color);
}

/* Estilos responsive */
@media (max-width: 768px) {
    .footer-top {
        grid-template-columns: 1fr;
    }

    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }

    .footer-legal {
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .newsletter-form {
        flex-direction: column;
    }

    .newsletter-input {
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }

    .newsletter-button {
        border-radius: 4px;
        padding: 0.75rem;
    }
}
</style>