<div class="container body">

    <?php if ($this->response && $this->error): ?>
        <h1 style="color: red"> <?php echo $this->response ?> </h1>
    <?php endif; ?>
    <?php if ($this->response && !$this->error): ?>
        <h1 style="color: green"> <?php echo $this->response ?> </h1>
    <?php endif; ?>

    <h2>Filtering</h2>

    <div class="inline" style=" width: 225px" >
        <form action="<?php echo "/".strtolower($this->name)."/setSorting/$this->path/$this->searchValue" ?>" >
            <label for="sorting">Sorting</label>
            <select name="sorting" id="sorting" class="button-primary" onchange="this.form.submit()">
                <option
                    <?php if (!isset($_SESSION["sorting"]) || $_SESSION["sorting"] == "ASC"): ?>
                        selected
                    <?php endif; ?>
                    value="ASC">Ascending</option>
                <option
                    <?php if (isset($_SESSION["sorting"]) && $_SESSION["sorting"] == "DESC"): ?>
                        selected
                    <?php endif; ?>
                    value="DESC">Descending</option>

            </select>
        </form>
    </div>

    <div class="inline" style=" width:  570px">
        <form action=" <?php echo "/".strtolower($this->name)."/filterByDate/$this->path/$this->searchValue" ?>">

            <div class="inline">
                    <label for="startDate">Start date</label>
                    <input type="date" name="startDate" id="startDate" class="input-filed" required
                         <?php if (isset($_SESSION["startDate"])): ?>
                             value="<?php echo $_SESSION["startDate"]; ?>"
                         <?php endif; ?>>
            </div>
            &nbsp;
            <div class="inline">
                    <label for="endDate">End date</label>
                    <input type="date" name="endDate" id="endDate" class="input-filed" required
                    <?php if (isset($_SESSION["endDate"])): ?>
                        value="<?php echo $_SESSION["endDate"]; ?>"
                    <?php endif; ?>>
            </div>

            <input type="submit" class="button-primary" value="Filter">
            <a href=" <?php echo "/".strtolower($this->name)."/clearFilterByDate/$this->path/$this->searchValue" ?>">
                <input type="button" class="button-warning" value="Clear">
            </a>
        </form>
    </div>

    <div class="inline" style="width:  445px">
        <form action=" <?php echo "/".strtolower($this->name)."/index/$this->path" ?> " method="get">
            <div class="inline">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="input-filed" placeholder="Search...">
            </div>
            <input type="submit" class="button-primary" value="Search">
        </form>
    </div>

</div>


