<template>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h2>Панель управления</h2>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-3" style="font-size: 2rem"
                        >&#x1F4C8;</span
                        >
                        <h5 class="card-title mb-0">Транзакции</h5>
                    </div>
                    <p class="card-text mb-2">Просмотр транзакций</p>
                    <router-link
                        to="/transactions"
                        class="btn btn-outline-primary"
                    >Посмотреть
                    </router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
};
</script>
