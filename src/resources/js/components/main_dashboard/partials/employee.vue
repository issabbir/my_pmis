<template>
    <div>
    <h3>Employeeddd</h3>
            <table class="table table-hover">
    <thead>
        <tr>
          <th scope="col">Type</th>
          <th scope="col">Column heading</th>
          <th scope="col">Column heading</th>
          <th scope="col">Column heading</th>
        </tr>
    </thead>
    <tbody>
      <tr class="table-active">
        <th scope="row">Active</th>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
  </tbody>
</table>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

