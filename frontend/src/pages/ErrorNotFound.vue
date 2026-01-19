<template>
  <div class="fullscreen text-black text-center q-pa-md flex flex-center">
    <div>
      <div class="flex flex-center column q-gutter-md">
        <div class="error-style">404</div>
        <h1 class="q-my-none">Seite nicht gefunden</h1>
        <div class="text-h6">Die Seite, die Sie aufrufen möchten, konnte nicht gefunden werden.</div>
      </div>

      <q-btn
        class="q-mt-xl"
        color="black"
        text-color="white"
        unelevated
        to="/"
        label="Zum Dashboard"
        no-caps
        icon-right="arrow_forward"
      />
    </div>
  </div>

</template>

<script setup>
//
</script>

<style scoped>
.error-style{
  font-size: 10rem;
  line-height: 1;
}
</style>
