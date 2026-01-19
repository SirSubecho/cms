<template>
  <q-btn flat round dense>
    <q-avatar size="32px">
      <q-avatar size="32px" color="white" text-color="black">
        {{ nameInitials }}
      </q-avatar>
    </q-avatar>

    <q-menu v-model="userDropOpen">
      <q-list style="min-width: 200px">
        <q-item>
          <q-item-section>
            <q-item-label>{{ authStore.user?.name }}</q-item-label>
            <q-item-label caption>{{ authStore.user?.email }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-separator />

        <q-item clickable v-close-popup @click="logout">
          <q-item-section>Ausloggen</q-item-section>
        </q-item>
      </q-list>
    </q-menu>
  </q-btn>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from 'stores/auth'

const router = useRouter()
const authStore = useAuthStore()
const userDropOpen = ref(false)

async function logout() {
  await authStore.logout()
  router.push('/login')
}

const nameInitials = computed(() => {
  if (!authStore.user || !authStore.user.name) return 'N/A'
  return authStore.user.name
    .split(' ')
    .map(n => n[0])
    .join('')
    .toUpperCase()
})

</script>
