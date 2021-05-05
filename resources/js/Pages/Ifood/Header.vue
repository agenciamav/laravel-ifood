<template>
  <div class="flex flex-row justify-between">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      <slot name="title"></slot>
    </h2>
    <select name="" id="" class="rounded-md pl-4 py-1 pr-12 m-0 w-auto">
      <option value="">Loja aberta</option>
      <option value="" selected>Loja fechada</option>
    </select>
  </div>
</template>
