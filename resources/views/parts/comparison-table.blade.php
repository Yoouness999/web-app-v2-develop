<div class="container">
    <div class="table-pricing">

        <table class="panel panel-primary">
            <thead class="panel-heading">
                <tr>
                    <td width="50%"><div class="p-10 pl-20 text-left"><?= $prices_table['title'][0]; ?></div></td>
                    <td width="25%"><div class="p-10"><?= $prices_table['title'][1]; ?></div></td>
                    <td width="25%"><div class="p-10"><?= $prices_table['title'][2]; ?></div></td>
                </tr>
            </thead>
            <tbody>
                @foreach($prices_table['features'] as $key => $feature)
                @if(is_array($feature))
                <tr>
                    <td class="col-1" valign="top">
                        <div class="pl-20">
                            <?= $feature['title']; ?>
                        </div>
                    </td>
                    <td valign="top" class="col-2 text-center">
                        <div class="p-5">
                            @if($feature['same'])
                                <i class="fa fa-check green" aria-hidden="true"></i><br/>
                            @else
                                <i class="fa fa-times grey" aria-hidden="true"></i><br/>
                            @endif
                        </div>
                    </td>
                    <td valign="top" class="col-3 text-center">
                        <div class="p-5">
                            <i class="fa fa-check green" aria-hidden="true"></i><br/>
                        </div>
                    </td>
                </tr>
                @else
                <tr>
                    <td class="col-1" valign="top">
                        <div class="pl-20">
                            <?= $feature; ?>
                        </div>
                    </td>
                    <td valign="top" class="col-2 text-center">
                        <div class="p-5">
                            <i class="fa fa-times grey" aria-hidden="true"></i><br/>
                        </div>
                    </td>
                    <td valign="top" class="col-3 text-center">
                        <div class="p-5">
                            <i class="fa fa-check green" aria-hidden="true"></i><br/>
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="col-1">
                        <div class="p-25 red">
                            <?= $prices_table['footer']['price_start'] ?>
                        </div>
                    </td>
                    <td colspan="2" class="col-2">
                        <div class="text-center">

                            <a href="<?= $prices_table['footer']['link'] ?>" class="btn btn-primary">
                                <?= $prices_table['footer']['start'] ?>
                            </a>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
