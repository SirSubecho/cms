<template>
  <q-layout view="hHh lpR fFf">
    <q-page-container>
      <q-page class="flex flex-center">
        <q-card style="width: 400px">
          <q-card-section>
            <div class="text-h6">CMS | Einloggen</div>
          </q-card-section>

          <q-card-section>
            <q-form @submit="onSubmit">
              <q-input
                v-model="email"
                label="Email"
                type="email"
                outlined
                :rules="[val => !!val || 'E-Mail wird benötigt']"
              />

              <q-input
                v-model="password"
                label="Passwort"
                type="password"
                outlined
                class="q-mt-md"
                :rules="[val => !!val || 'Passwort wird benötigt']"
              />

              <q-btn
                label="Login"
                type="submit"
                color="primary"
                class="full-width q-mt-md"
                :loading="loading"
              />
            </q-form>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useQuasar } from 'quasar'
import { useAuthStore } from 'stores/auth'

const router = useRouter()
const $q = useQuasar()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const loading = ref(false)

const onSubmit = async () => {
  loading.value = true
  try {
    await authStore.login({
      email: email.value,
      password: password.value
    })

    $q.notify({
      type: 'positive',
      message: 'Erfolgreich eingeloggt'
    })

    router.push('/')
  } catch (error) {
    console.error(error)
    $q.notify({
      type: 'negative',
      message: 'Login fehlgeschlagen'
    })
  } finally {
    loading.value = false
  }
}
</script>
