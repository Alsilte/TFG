<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

// Estado del formulario
const username = ref('');
const password = ref('');
const errorMessage = ref('');
const loading = ref(false);

// Función para volver al inicio
const volverAlInicio = () => {
  router.push('/');
};

// Función para manejar el inicio de sesión
const handleLogin = () => {
    errorMessage.value = '';
    loading.value = true;

    if (!username.value || !password.value) {
        errorMessage.value = 'Por favor, completa todos los campos';
        loading.value = false;
        return;
    }

    // Credenciales de administrador
    if (username.value === 'admin' && password.value === 'admin123') {
        setTimeout(() => {
            localStorage.setItem('isAuthenticated', 'true');
            localStorage.setItem('userRole', 'admin');
            router.push('/admin/dashboard');
            loading.value = false;
        }, 1000);
    }
    // Credenciales de usuario normal
    else if (username.value === 'usuario' && password.value === 'usuario123') {
        setTimeout(() => {
            localStorage.setItem('isAuthenticated', 'true');
            localStorage.setItem('userRole', 'user');
            router.push('/user/profile');
            loading.value = false;
        }, 1000);
    } else {
        setTimeout(() => {
            errorMessage.value = 'Credenciales incorrectas. Intenta con "admin/admin123" o "usuario/usuario123"';
            loading.value = false;
        }, 1000);
    }
};
</script>

<template>
    <div class="login-container">
        <div class="login-box">
            <button @click="volverAlInicio" class="back-button">
                <span class="back-icon">←</span>
                <span>Volver al inicio</span>
            </button>
            
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo-circle">
                        <span class="logo-icon">⚽</span>
                    </div>
                </div>
                <h2>¡Bienvenido!</h2>
                <p>Inicia sesión para acceder a tu cuenta</p>
            </div>

            <form @submit.prevent="handleLogin" class="login-form">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <div class="input-container">
                        <span class="input-icon">👤</span>
                        <input type="text" id="username" v-model="username" placeholder="Ingresa tu nombre de usuario"
                            required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-container">
                        <span class="input-icon">🔒</span>
                        <input type="password" id="password" v-model="password" placeholder="Ingresa tu contraseña"
                            required />
                    </div>
                </div>

                <div v-if="errorMessage" class="error-message">
                    <span class="error-icon">⚠️</span>
                    {{ errorMessage }}
                </div>

                <div class="remember-forgot">
                    <label class="remember-label">
                        <input type="checkbox" class="remember-checkbox">
                        <span class="checkbox-text">Recordarme</span>
                    </label>
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="login-button" :disabled="loading">
                    <span v-if="!loading">Iniciar Sesión</span>
                    <span v-else class="loading-spinner">
                        <span class="spinner"></span>
                        Cargando...
                    </span>
                </button>
            </form>

            <div class="login-footer">
                <p>¿No tienes una cuenta? <a href="#">Regístrate ahora</a></p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 2rem;
    background-color: #f8f9fa;
    background-image: linear-gradient(135deg, #f8f9fa 0%, #F2EB85 100%);
}

.login-box {
    width: 100%;
    max-width: 420px;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    position: relative;
}

.login-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    align-items: center;
    background: #818C30;
    border: none;
    border-radius: 10px;
    color: #ffffff;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    padding: 10px;
    transition: all 0.3s ease;
}

.back-button:hover {
    color: #F2EB85;
    transform: translateX(-3px);
}

.back-icon {
    margin-right: 6px;
    font-size: 1.1rem;
}

.login-header {
    text-align: center;
    margin-bottom: 2.5rem;
    margin-top: 1.5rem;
}

.logo-container {
    margin-bottom: 1.5rem;
}

.logo-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #818C30 0%, #6A7327 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 8px 20px rgba(129, 140, 48, 0.3);
}

.logo-icon {
    font-size: 40px;
    display: block;
    margin: 0 auto;
}

.login-header h2 {
    color: #262626;
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
    font-weight: 600;
}

.login-header p {
    color: #262626;
    opacity: 0.7;
    margin: 0;
    font-size: 1rem;
}

.login-form {
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #262626;
    font-size: 0.95rem;
}

.input-container {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 15px;
    font-size: 1rem;
    opacity: 0.7;
}

.form-group input {
    width: 100%;
    padding: 0.9rem 1rem 0.9rem 45px;
    border: 1px solid rgba(129, 140, 48, 0.2);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background-color: rgba(242, 235, 133, 0.05);
}

.form-group input:focus {
    outline: none;
    border-color: #818C30;
    box-shadow: 0 0 0 3px rgba(129, 140, 48, 0.15);
    background-color: white;
}

.form-group input::placeholder {
    color: #262626;
    opacity: 0.5;
}

.error-message {
    display: flex;
    align-items: center;
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    border-left: 3px solid #dc3545;
}

.error-icon {
    margin-right: 10px;
    font-size: 1.1rem;
}

.remember-forgot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.remember-label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.remember-checkbox {
    margin-right: 8px;
    cursor: pointer;
    accent-color: #818C30;
}

.checkbox-text {
    color: #262626;
}

.forgot-link {
    color: #818C30;
    text-decoration: none;
    transition: color 0.3s;
}

.forgot-link:hover {
    color: #6A7327;
    text-decoration: underline;
}

.login-button {
    width: 100%;
    padding: 0.9rem;
    background-color: #818C30;
    color: #F2EB85;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-button:hover {
    background-color: #6A7327;
    box-shadow: 0 4px 12px rgba(106, 115, 39, 0.3);
    transform: translateY(-2px);
}

.login-button:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(106, 115, 39, 0.3);
}

.login-button:disabled {
    background-color: #a8a8a8;
    transform: none;
    box-shadow: none;
    cursor: not-allowed;
}

.loading-spinner {
    display: flex;
    align-items: center;
}

.spinner {
    display: inline-block;
    width: 18px;
    height: 18px;
    border: 2px solid #F2EB85;
    border-radius: 50%;
    border-top-color: transparent;
    margin-right: 10px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.login-footer {
    text-align: center;
    font-size: 0.95rem;
    color: #262626;
    opacity: 0.7;
    margin-top: 2rem;
}

.login-footer a {
    color: #818C30;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

.login-footer a:hover {
    color: #6A7327;
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 480px) {
    .login-box {
        padding: 2rem 1.5rem;
        max-width: 100%;
    }

    .logo-circle {
        width: 70px;
        height: 70px;
    }

    .logo-icon {
        font-size: 35px;
    }

    .login-header h2 {
        font-size: 1.6rem;
    }

    .remember-forgot {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.8rem;
    }
    
    .back-button {
        top: 15px;
        left: 15px;
        font-size: 0.85rem;
    }
}
</style>