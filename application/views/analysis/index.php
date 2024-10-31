<div class="container mx-auto mt-8">
  <div class="bg-white rounded-[20px] shadow bg-white relative w-full p-8">
    <h1 class="text-xl font-bold mb-4">Hasil Model Decision Tree</h1>
    <div class="mb-3">
        <h2 class="font-semibold">Mean Squared Error:</h2>
        <?php echo $results['Mean Squared Error']; ?>
    </div>
    <div class="mb-3">
        <h2 class="font-semibold">R-squared:</h2>
        <?php echo $results['R-squared']; ?>
    </div>
    <div class="mb-3 font-normal">
        <h2 class="font-semibold">Aturan Decision Tree:</h2>
        <pre><?php echo nl2br($results['Decision Tree Rules']); ?></pre>
    </div>
  </div>
</div>