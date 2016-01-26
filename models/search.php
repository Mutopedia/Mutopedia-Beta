<div id="search-container">
	<div id="input-container">
		<input type="text" placeholder="Search a player by username or by mutant tag">
	</div>

	<div id="option-layout-container">
		<div id="option-layout-title">
			<h3>Option View</h3>
		</div>
		<div value="row" class="option-layout-button">
			<p>Row</p>
		</div>
		<div value="block" class="option-layout-button unactive">
			<p>Block</p>
		</div>
	</div>

	<div id="option-sort-container">
		<div id="option-sort-title">
			<h3>Sort By</h3>
		</div>
		<div class="select" value="user-asc">
			<div class="icon">
		 				
		 	</div>
		 	<div class="value">
		 		<h3>increasing Username</h3>
		 	</div>
		  	<div class="ul">
				<div class="li" value="fame-asc">
					<p>increasing Level Fame</p>
				</div>
				<div class="li" value="fame-desc">
					<p>decreasing Level Fame</p>
				</div>
				<div class="li" value="center-asc">
					<p>increasing Level Center</p>
				</div>
				<div class="li" value="center-desc">
					<p>decreasing Level Center</p>
				</div>
				<div class="li" value="mutant-asc">
					<p>increasing Mutant</p>
				</div>
				<div class="li" value="mutant-desc">
					<p>decreasing Mutant</p>
				</div>
				<div class="li" value="user-asc">
					<p>increasing Username</p>
				</div>
				<div class="li" value="user-desc">
					<p>decreasing Username</p>
				</div>
		  	</div>
		</div>
	</div>

	<div id="option-row-container">
		<div>
			<h3><span class="mark">Picture</span></h3>
		</div>
		<div>
			<h3><span class="mark">Username</span></h3>
		</div>
		<div>
			<h3><span class="mark">Mutant</span></h3>
		</div>
		<div>
			<h3><span class="mark">Genes</span></h3>
		</div>
		<div>
			<h3><span class="mark">Fame Level</span></h3>
		</div>
		<div>
			<h3><span class="mark">Center Level</span></h3>
		</div>
	</div>

	<div id="result-container">
		<script type="text/javascript">
			searchUsers();
		</script>
	</div>

	<div id="error-container">
		<h2></h2>
	</div>
</div>
