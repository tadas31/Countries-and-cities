<div class="container">


    <h2>Add country</h2>

    <form action="/countries/save" method="get">
        <div class="inline">
            <label for="name">Country name</label>
            <input type="text" name="name" id="name" placeholder="Country name" class="input-filed" required>
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
            <label for="phoneCode">Phone code</label>
            <input type="text" name="phoneCode" id="phoneCode" placeholder="Phone code" class="input-filed" required>
        </div>

        <input type="submit" class="button-primary" value="Save">
    </form>

    <h2>Created countries</h2>

    <?php if (sizeof($this->countriesInPage) > 0): ?>
        <table >
            <col width="25%" />
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
            <col width="15%" />

            <tr>
                <th>Country name</th>
                <th>Country area</th>
                <th>Country population</th>
                <th>Country phone code</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($this->countriesInPage as $country): ?>


            <?php if ( isset($_SESSION["editing"]) && $country->id == $_SESSION["editing"]): ?>


                <tr>

                    <form action=" <?php echo "/countries/update/$this->path/$this->searchValue" ?>" method="get">
                        <td><input type="text" name="name" id="name" placeholder="name" value="<?php echo $country->name ?>" class="table-input" required></td>
                        <td><input type="number" step="0.01" name="area" id="area" placeholder="area" value="<?php echo $country->area ?>" class="table-input" required></td>
                        <td><input type="number" name="population" id="population" placeholder="population" value="<?php echo $country->population ?>" class="table-input" required></td>
                        <td><input type="text" name="phoneCode" id="phoneCode" placeholder="phone code" value="<?php echo $country->phone_code ?>" class="table-input" required></td>

                        <td>
                            <input type="submit" class="button-primary" value="Save">
                            <a href=" <?php echo "/countries/setEditing/$country->id/$this->path/$this->searchValue" ?>"><input type="button" class="button-warning" value="Cancel"></a>
                        </td>

                    </form>
                </tr>


            <?php else: ?>
                <tr  onMouseOver="this.style.backgroundColor='#D0D0D0'; this.style.cursor='pointer';"
                     onMouseOut="this.style.backgroundColor='#FFFFFF'; this.style.cursor='default';" >

                    <td onClick="window.location='<?php echo "/cities/index/$country->id/1"?>'" ><?php echo $country->name ?></td>
                    <td onClick="window.location='<?php echo "/cities/index/$country->id/1"?>'" ><?php echo $country->area ?></td>
                    <td onClick="window.location='<?php echo "/cities/index/$country->id/1"?>'" ><?php echo $country->population ?></td>
                    <td onClick="window.location='<?php echo "/cities/index/$country->id/1"?>'" ><?php echo $country->phone_code ?></td>
                    <td>
                        <a href="<?php echo "/countries/setEditing/$country->id/$this->path/$this->searchValue" ?>"><input type="button" class="button-primary" value="Edit"></a>
                        <input type="button" class="button-warning" value="Delete" onClick="conf('<?php echo $country->name ?>', '<?php echo "/countries/delete/$country->id/$this->path/$this->searchValue" ?>')">
                    </td>
                </tr>
            <?php endif; ?>

            <?php endforeach; ?>

        </table>


        <br><br>

        <div class="center">
            <div class="pagination">
                <?php if ($this->pagesCount > 1): ?>

                    <?php if ($this->currentPage > 3): ?>
                        <a href="<?php echo "/countries/index/1/$this->searchValue" ?>" class="">First</a>
                    <?php endif; ?>

                    <?php if ($this->currentPage > 1): ?>
                        <a href="<?php echo "/countries/index/".($this->currentPage - 1)."/$this->searchValue" ?>" class="">Prev</a>
                    <?php endif; ?>

                    <?php if ($this->currentPage > 3): ?>
                        <?php for ($i = $this->currentPage - 3; $i < $this->currentPage; $i++): ?>
                            <a href="<?php echo "/countries/index/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php else: ?>
                        <?php for ($i = 1; $i < $this->currentPage; $i++): ?>
                            <a href="<?php echo "/countries/index/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php endif; ?>

                    <a href="<?php echo "/countries/index/$this->currentPage/$this->searchValue" ?>" class="active"><?php echo $this->currentPage ?></a>

                    <?php if ($this->currentPage + 3 < $this->pagesCount): ?>
                        <?php for ($i = $this->currentPage + 1; $i <= $this->currentPage + 3; $i++): ?>
                            <a href="<?php echo "/countries/index/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php else: ?>
                        <?php for ($i = $this->currentPage + 1; $i <= $this->pagesCount; $i++): ?>
                            <a href="<?php echo "/countries/index/$i/$this->searchValue" ?>"><?php echo $i ?></a>
                        <?php endfor; ?>
                    <?php endif; ?>

                    <?php if ($this->currentPage < $this->pagesCount): ?>
                        <a href="<?php echo "/countries/index/".($this->currentPage + 1)."/$this->searchValue" ?>">Next</a>
                    <?php endif; ?>

                    <?php if ($this->currentPage + 3 < $this->pagesCount): ?>
                        <a href="<?php echo "/countries/index/$this->pagesCount/$this->searchValue" ?>" class="">Last</a>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>

        <h3>No countries found</h3>

    <?php endif; ?>

</div>