<table class='reqsTable'>
    <caption>Список всех запросов</caption>
    <thead>
        <tr>
            <!-- <th></th> -->
            <th><span>#</span> | Дата</th>
            <th>Этапы</th>
            <th>Автор</th>
            <th></th>
            <th>VK</th>
            <!-- <th>@</th> -->
            <th>Delete | Archive</th>
            <!-- <th></th> -->
        </tr>
    </thead>
    <tbody id="active">
        [{ REQS }]
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">Всего заявок на сайте: [{ REQS_COUNT }], из них:<br> - завершенно: [{ REQS_FINISH_COUNT }]<br> - активны: [{ REQS_ACTIVE_COUNT }]<br> - отколнено: [{ REQS_FAIL_COUNT }]<br><br> В архиве: [{ REQS_ARCHIVE_COUNT }]</td>
        </tr>
    </tfoot>
    <tbody id="new" style="background-color: #002005;">
        [{ REQS_NEW }]
    </tbody>
    <tbody id="archive" style="background-color: #000000;">
        [{ REQS_ARCHIVE }]
    </tbody>
</table>