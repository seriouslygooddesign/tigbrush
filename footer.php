</main>
<?php if (CAN_SHOW_PRIVATE_ELEMENT): ?>
	<footer class="main-footer bg-primary text-white fs-sm underline-reverse">
		<div class="container section-py">
			<div class="row gx-4 gy-2">
				<?php
				for ($i = 1; $i <= FOOTER_SIDEBAR_QUANTITY; $i++) {
					$sidebar_name = "footer-sidebar-$i";
					if (is_active_sidebar($sidebar_name)) {
						dynamic_sidebar($sidebar_name);
					}
				}
				?>
			</div>
		</div>
		<div class="bg-dark">
			<div class="container fs-md">
				<div class="row">
					<div class="col">
						<?= get_field('legal_information', 'option') ?>
					</div>
					<div class="col-md-auto">
						<p class="text-end">Website by <a class="fw-600" href="https://sgd.com.au/" target="_blank">SGD</a></p>
					</div>
				</div>
			</div>
		</div>
	</footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>

</html>