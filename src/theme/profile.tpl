<section class="Profile">
	<div class="Profile__wrap wrap">
		<div class="Profile__top flex flex--aic flex--jcs">
			<div class="Profile__avatar"><img src="[{ AVATAR }]" alt="[{ NAME }]"></div>
			<div class="Profile__info flex flex--aic flex--jcs">
				<div class="Profile__name"><a href="//vk.com/id[{ VK }]" target="_blank">[{ NAME }]</a></div>
				<div class="Profile__reg">[{ REG }]</div>
				<div class="Profile__email">
					[{ SET_EMAIL }]
					[{ EMAIL }] <a style='margin-left: 10px;' href="/p/email/"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width='12px'><path fill="#FFF" d="M481.996,30.006C462.647,10.656,436.922,0,409.559,0c-27.363,0-53.089,10.656-72.438,30.005L50.826,316.301 c-2.436,2.436-4.201,5.46-5.125,8.779L0.733,486.637c-1.939,6.968,0.034,14.441,5.163,19.542c3.8,3.78,8.892,5.821,14.106,5.821 c1.822,0,3.66-0.25,5.463-0.762l161.557-45.891c6.816-1.936,12.1-7.335,13.888-14.192c1.788-6.857-0.186-14.148-5.189-19.167 L93.869,329.827L331.184,92.511l88.258,88.258L237.768,361.948c-7.821,7.8-7.838,20.463-0.038,28.284 c7.799,7.822,20.464,7.838,28.284,0.039l215.98-215.392C501.344,155.53,512,129.805,512,102.442 C512,75.079,501.344,49.354,481.996,30.006z M143.395,436.158L48.827,463.02l26.485-95.152L143.395,436.158z M453.73,146.575 l-5.965,5.949l-88.296-88.297l5.938-5.938C377.2,46.495,392.88,40,409.559,40c16.679,0,32.358,6.495,44.152,18.29 C465.505,70.083,472,85.763,472,102.442C472,119.121,465.505,134.801,453.73,146.575z"/></svg>
					</a>
					[{ /SET_EMAIL }]
					[{ NOTSET_EMAIL }]
					<form action="" method="POST" class='flex flex--aic flex--jcs'>
						<input type="email" name='email' placeholder="Введите ваш email" required>
						<button>Сохранить</button>
					</form>
					[{ /NOTSET_EMAIL }]
				</div>
			</div>
		</div>
		<div class="Profile__alert">
			[{ CHECKEMAIL }]
			<div>Вам необходимо подтвердиnь вашу почту.</div>
			[{ /CHECKEMAIL }]
			[{ NOTSET_EMAIL }]
			<div>Вам необходимо указать вашу почту для получения уведомлений.</div>
			[{ /NOTSET_EMAIL }]
		</div>
		<div class="Profile__reqs">
			<table>
				<thead>
					<tr>
						<th colspan="2">Заявки</th>
						<!-- <th class='nick'></th> -->
						<th colspan="3">Этапы</th>
					</tr>
					<tr>
						<th width="50">#</th>
						<th width="150">Дата</th>
						<!-- <th class='nick'></th> -->
						<th class='stepRow'>1</th>
						<th class='stepRow'>2</th>
						<th class='stepRow'>3</th>
					</tr>
				</thead>
				<tbody>
					[{ REQS }]
				</tbody>
				<tfoot>
					<tr>
						<!-- <td colspan="3"></td> -->
						<td colspan="5">
							<div class="flex flex--aic flex--jcs">
								<div class="stepInf"><div data-step="open"></div> - Доступно</div>
								<div class="stepInf"><div data-step="close"></div> - Недоступно</div>
								<div class="stepInf"><div data-step="ok"></div> - Проверено, положительно.</div>
								<div class="stepInf"><div data-step="info"></div> - Есть уведомление</div>
								<div class="stepInf"><div data-step="send"></div> - Отправлено на проверку</div>
								<div class="stepInf"><div data-step="fail"></div> - Проверено, отколнено</div>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		[{ HAVE_OPEN }]
		<div class="Profile__bttns flex flex--aic flex--jcc">
			<a href="/req/new/" class="Bttn">Новая заявка</a>
		</div>
		[{ /HAVE_OPEN }]
	</div>
</section>