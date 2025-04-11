<script setup>
// Datos del usuario (en un entorno real vendrían de una API)
const userProfile = {
    name: 'Usuario Normal',
    email: 'usuario@ejemplo.com',
    team: 'Atlético Norte',
    joinDate: '10/01/2025',
    tournaments: 3
};
</script>

<template>
    <div class="user-profile">
        <h1 class="profile-title">Mi Perfil</h1>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <div class="profile-info">
                    <h2 class="profile-name">{{ userProfile.name }}</h2>
                    <p class="profile-email">{{ userProfile.email }}</p>
                </div>
            </div>

            <div class="profile-details">
                <div class="detail-item">
                    <span class="detail-label">Equipo:</span>
                    <span class="detail-value">{{ userProfile.team }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Fecha de registro:</span>
                    <span class="detail-value">{{ userProfile.joinDate }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Torneos participados:</span>
                    <span class="detail-value">{{ userProfile.tournaments }}</span>
                </div>
            </div>

            <div class="profile-actions">
                <button class="btn btn-primary">Editar Perfil</button>
                <button class="btn btn-secondary">Cambiar Contraseña</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.user-profile {
    width: 100%;
}

.profile-title {
    margin-top: 0;
    margin-bottom: 2rem;
    color: #262626;
    font-size: 1.8rem;
    font-weight: 600;
}

.profile-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(38, 38, 38, 0.08);
    overflow: hidden;
}

.profile-header {
    display: flex;
    align-items: center;
    padding: 2rem;
    background: linear-gradient(135deg, rgba(129, 140, 48, 0.15) 0%, rgba(106, 115, 39, 0.1) 100%);
    border-bottom: 1px solid rgba(129, 140, 48, 0.2);
}

.profile-avatar {
    width: 100px;
    height: 100px;
    background-color: #818C30;
    color: #F2EB85;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    margin-right: 2rem;
    box-shadow: 0 4px 10px rgba(38, 38, 38, 0.15);
    border: 3px solid rgba(242, 235, 133, 0.5);
}

.profile-info {
    flex: 1;
}

.profile-name {
    margin: 0 0 0.5rem 0;
    font-size: 1.5rem;
    color: #262626;
    font-weight: 600;
}

.profile-email {
    margin: 0;
    color: #262626;
    opacity: 0.7;
    font-size: 0.95rem;
}

.profile-details {
    padding: 2rem;
    border-bottom: 1px solid rgba(129, 140, 48, 0.15);
}

.detail-item {
    margin-bottom: 1.2rem;
    display: flex;
    align-items: center;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-label {
    width: 200px;
    font-weight: 500;
    color: #262626;
}

.detail-value {
    flex: 1;
    color: #262626;
    opacity: 0.8;
}

.profile-actions {
    padding: 2rem;
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.btn-primary {
    background-color: #818C30;
    color: #F2EB85;
}

.btn-primary:hover {
    background-color: #6A7327;
    box-shadow: 0 4px 8px rgba(38, 38, 38, 0.15);
}

.btn-secondary {
    background-color: rgba(129, 140, 48, 0.15);
    color: #262626;
}

.btn-secondary:hover {
    background-color: rgba(129, 140, 48, 0.25);
    box-shadow: 0 4px 8px rgba(38, 38, 38, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-avatar {
        margin-right: 0;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .detail-label {
        width: 100%;
        margin-bottom: 0.3rem;
        font-weight: 600;
    }

    .profile-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>