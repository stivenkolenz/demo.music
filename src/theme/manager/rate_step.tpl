<section class="RateReq" id='rate'>
	[{ NHR }]
	<h2 class="RateReq__title">Оценить работу</h2>
	<form action="" class='RateReq__form' method="POST">
		<select name="rate">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<textarea name="comment" placeholder="Есть что прокоментировать?"></textarea>
		<button name="add_rate">Добавить оценку</button>
	</form>
	[{ /NHR }]
	<b>Всего оценок: [{ RATE_COUNT }] (AVG: [{ RATE_AVG }])</b>
	<div class="RateReq__list">
		<table>
			<thead>
				<tr>
					<th>Кто</th>
					<th>Оценка</th>
					<th>Комментарий</th>
				</tr>
			</thead>
			<tbody>
				[{ RATE }]
			</tbody>
		</table>
	</div>
	[{ HR }]
	<a href="?removerate=true" class="RateReq__removeRate">Удалить мою оценку</a>
	[{ /HR }]
</section>

