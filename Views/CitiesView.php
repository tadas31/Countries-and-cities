
<div class="container">

    <h2>Add city</h2>

    <form action="<?php echo "/cities/save/$this->countryId" ?>" method="get">
        <div class="inline">
            <label for="name">City name</label>
            <input type="text" name="name" id="name" placeholder="City name" class="input-filed" required>
        </div>
        &nbsp;
        <div class="inline">
            <label for="area">Area</label>
            <input type="number" step="0.01" name="area" id="area" placeholder="Area" class="input-filed" required>
        </div>
        &nbsp;
        <div class="inline">
            <label for="population">Population</label>
            <input type="number" name="population" id="population" placeholder="Population" class="input-filed" required>
        </div>
        &nbsp;
        <div class="inline">
            <label for="postalCode">Postal code</label>
            <input type="text" name="postalCode" id="postalCode" placeholder="Postal code" class="input-filed" required>
        </div>
        <input type="submit" class="button-primary" value="Save">
    </form>

    <h2>Created cities for <?php echo $this->countryName ?> </h2>

    <?php if (sizeof($this->citiesInPage) > 0): ?>
        <table>
            <col width="25%" />
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
            <col width="15%" />

            <tr>
                <th>City name</th>
                <th>City area</th>
                <th>City population</th>
                <th>City postal code</th>
                <th>Actions</th>
            </tr>

        <?php foreach ($this->citiesInPage as $city):?>


            <?php if ( isset($_SESSION["editing"]) && $city->id == $_SESSION["editing"]): ?>


                <tr>

                    <form action="<?php echo "/cities/update/$this->path/$this->searchValue" ?>" method="get">
                        <td><input type="text" name="name" id="name" placeholder="name" value="<?php echo $city->name ?>" class="table-input" required></td>
                        <td><input type="number" step="0.01" name="area" id="area" placeholder="area" value="<?php echo $city->area ?>" class="table-input" required></td>
                        <td><input type="number" name="population" id="population" placeholder="population" value="<?php echo $city->population ?>" class="table-input" required></td>
                        <td><input type="text" name="postalCode" id="postalCode" placeholder="postal code" value="<?php echo $city->postal_code ?>" class="table-input" required></td>

                        <td>
                            <input type="submit" class="button-primary" value="Save">
                            <a href="<?php echo "/cities/setEditing/$city->id/$this->path/$this->searchValue" ?>"><input type="button" class="button-warning" value="Cancel"></a>
                        </td>

                    </form>
                </tr>


            <?php else: ?>
                <tr  onMouseOver="this.style.backgroundColor='#D0D0D0'; "
                     onMouseOut="this.style.backgroundColor='#FFFFFF'; " >

                    <td><?php echo $city->name ?></td>
                    <td><?php echo $city->area ?></td>
                    <td><?php echo $city->population ?></td>
                    <td><?php echo $city->postal_code ?></td>
                    <td>
                        <a href="<?php echo "/cities/setEditing/$city->id/$this->path/$this->searchValue" ?>"><input type="button" class="button-primary" value="Edit"></a>
                        <input type="button" class="button-warning" value="Delete" onClick="conf('<?php echo $city->name ?>', '<?php echo "/cities/delete/$city->id/$this->path/$this->searchValue" ?>')">
                    </td>
                </tr>
            <?php endif; ?>

    <?php endforeach;?>
        </table>
        <br><br>

        <div class="center">
            <div class="pagination">
                <?php if ($this->pagesCount > 1): ?>

                    <?php if ($this->currentPage > 3): ?>
                        <a href="<?php echo "/cities/index/$this->countryId/1/$this->searchValue" ?>" class="">First</a>
                    <?php endif; ?>

                    <?php if ($this->currentPage > 1): ?>
                        <a href="<?php echo "/cities/index/$this->countryId/".($this->currentPage - 1)."/$this->searchValue" ?>" class="">Prev</a>
                    <?php endif; ?>

                    <?php if ($this->currentPage > 3): ?>
                        <?php for ($i = $this->currentPage - 3; $i < $this->currentPage; $i++): ?>
                            <a href="<?php echo "/cities/index/$this->countryId/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php else: ?>
                        <?php for ($i = 1; $i < $this->currentPage; $i++): ?>
                            <a href="<?php echo "/cities/index/$this->countryId/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php endif; ?>

                    <a href="<?php echo "/cities/index/$this->countryId/$this->currentPage/$this->searchValue" ?>" class="active"><?php echo $this->currentPage ?></a>

                    <?php if ($this->currentPage + 3 < $this->pagesCount): ?>
                        <?php for ($i = $this->currentPage + 1; $i <= $this->currentPage + 3; $i++): ?>
                            <a href="<?php echo "/cities/index/$this->countryId/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php else: ?>
                        <?php for ($i = $this->currentPage + 1; $i <= $this->pagesCount; $i++): ?>
                            <a href="<?php echo "/cities/index/$this->countryId/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php endif; ?>

                    <?php if ($this->currentPage < $this->pagesCount): ?>
                        <a href="<?php echo "/cities/index/$this->countryId/".($this->currentPage + 1)."/$this->searchValue" ?>">Next</a>
                    <?php endif; ?>

                    <?php if ($this->currentPage + 3 < $this->pagesCount): ?>
                        <a href="<?php echo "/cities/index/$this->countryId/$this->pagesCount/$this->searchValue" ?>" class="">Last</a>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>

        <h3>No cities found</h3>

    <?php endif; ?>

</div>