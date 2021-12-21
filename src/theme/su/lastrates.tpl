<section class="LastRates">
	<h2 class="LastRates__title">Последние оценки</h2>
	<div class="LastRates__window [{ IS_REQ }]LastRates__window--full[{ /IS_REQ }]">
		<div class="LastRates__list">
			[{ RATES }]
		</div>
	</div>
	[{ IS_REQ }]
	<div class="LastRates__add">
		<div class="addRate">
			<h2 class="addRate__title">[{ NOT-HAVE }]Добавить[{ /NOT-HAVE }][{ HAVE }]Изменить[{ /HAVE }] свою оценку</h2>
			<form method="POST" class="addRate__form">
				[{ HAVE }]<input type="checkbox" value="1" name="have" checked hidden>[{ /HAVE }]
				<select name="rate" required class="addRate__select">
					<option value="">Выбери оценку</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<textarea name="comment" placeholder="Введите свой комменатрий к дэмо" required class="addRate__area"></textarea>
				<button class="addRate__bttn Bttn" name="setrate">Добавить оценку</button>
			</form>
		</div>
	</div>
	[{ /IS_REQ }]
</section>