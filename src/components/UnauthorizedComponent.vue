<template>
    <div class="unauthorized-container">
        <div class="unauthorized-content">
            <div class="unauthorized-icon">🔒</div>
            <h1>Acceso No Autorizado</h1>
            <p>No tienes permiso para acceder a esta página.</p>

            <div class="unauthorized-actions">
                <button @click="goHome" class="btn btn-primary">Ir al inicio</button>
                <button @click="goBack" class="btn btn-secondary">Volver atrás</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const goHome = () => {
    router.push('/');
};

const goBack = () => {
    router.go(-1);
};
</script>

<style scoped>
.unauthorized-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f5f7fa;
    padding: 2rem;
}

.unauthorized-content {
    text-align: center;
    background-color: white;
    padding: 3rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
}

.unauthorized-icon {
    font-size: 5rem;
    margin-bottom: 1.5rem;
}

h1 {
    color: var(--dark-color);
    margin-bottom: 1rem;
}

p {
    color: #7f8c8d;
    margin-bottom: 2rem;
}

.unauthorized-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

@media (max-width: 480px) {
    .unauthorized-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>