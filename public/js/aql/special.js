//normal inspection
function specialLevel(batchSize, specialLvl){
	if (batchSize >= 2 && batchSize <=8) {
		if (specialLvl == 'S1') {
			return 'A';
		}else if(specialLvl == 'S2'){
			return 'A';
		}else if(specialLvl == 'S3'){
			return 'A';
		}else if(specialLvl == 'S4'){
			return 'A'
		}
	}

	if (batchSize >= 9 && batchSize <=15) {
		if (specialLvl == 'S1') {
			return 'A';
		}else if(specialLvl == 'S2'){
			return 'A';
		}else if(specialLvl == 'S3'){
			return 'A';
		}else if(specialLvl == 'S4'){
			return 'A';
		}
	}

	if (batchSize >= 16 && batchSize <=25) {
		if (specialLvl == 'S1') {
			return 'A';
		}else if(specialLvl == 'S2'){
			return 'A';
		}else if(specialLvl == 'S3'){
			return 'D';
		}else if(specialLvl == 'S4'){
			return 'D';
		}
	}

	if (batchSize >= 26 && batchSize <=50) {
		if (specialLvl == 'S1') {
			return 'A';
		}else if(specialLvl == 'S2'){
			return 'B';
		}else if(specialLvl == 'S3'){
			return 'B';
		}else if(specialLvl == 'S4'){
			return 'C'
		}
	}

	if (batchSize >= 51 && batchSize <=90) {
		if (specialLvl == 'S1') {
			return 'B';
		}else if(specialLvl == 'S2'){
			return 'B';
		}else if(specialLvl == 'S3'){
			return 'C';
		}else if(specialLvl == 'S4'){
			return 'C';
		}
	}

	if (batchSize >= 91 && batchSize <=150) {
		if (specialLvl == 'S1') {
			return 'B';
		}else if(specialLvl == 'S2'){
			return 'B';
		}else if(specialLvl == 'S3'){
			return 'C';
		}else if(specialLvl == 'S4'){
			return 'D';
		}
	}

	if (batchSize >= 151 && batchSize <=280) {
		if (specialLvl == 'S1') {
			return 'B';
		}else if(specialLvl == 'S2'){
			return 'C';
		}else if(specialLvl == 'S3'){
			return 'D';
		}else if(specialLvl == 'S4'){
			return 'E'
		}
	}

	if (batchSize >= 281 && batchSize <=500) {
		if (specialLvl == 'S1') {
			return 'B';
		}else if(specialLvl == 'S2'){
			return 'C';
		}else if(specialLvl == 'S3'){
			return 'D';
		}else if(specialLvl == 'S4'){
			return 'E';
		}
	}

	if (batchSize >= 501 && batchSize <=1200) {
		if (specialLvl == 'S1') {
			return 'C';
		}else if(specialLvl == 'S2'){
			return 'C';
		}else if(specialLvl == 'S3'){
			return 'E';
		}else if(specialLvl == 'S4'){
			return 'F';
		}
	}

	if (batchSize >= 1201 && batchSize <=3200) {
		if (specialLvl == 'S1') {
			return 'C';
		}else if(specialLvl == 'S2'){
			return 'D';
		}else if(specialLvl == 'S3'){
			return 'E';
		}else if(specialLvl == 'S4'){
			return 'G';
		}
	}

	if (batchSize >= 3201 && batchSize <=10000) {
		if (specialLvl == 'S1') {
			return 'C';
		}else if(specialLvl == 'S2'){
			return 'D';
		}else if(specialLvl == 'S3'){
			return 'F';
		}else if(specialLvl == 'S4'){
			return 'G';
		}
	}

	if (batchSize >= 10001 && batchSize <=35000) {
		if (specialLvl == 'S1') {
			return 'C';
		}else if(specialLvl == 'S2'){
			return 'D';
		}else if(specialLvl == 'S3'){
			return 'F';
		}else if(specialLvl == 'S4'){
			return 'H';
		}
	}

	if (batchSize >= 35001 && batchSize <=150000) {
		if (specialLvl == 'S1') {
			return 'D';
		}else if(specialLvl == 'S2'){
			return 'E';
		}else if(specialLvl == 'S3'){
			return 'G';
		}else if(specialLvl == 'S4'){
			return 'J';
		}
	}

	if (batchSize >= 150001 && batchSize <=500000) {
		if (specialLvl == 'S1') {
			return 'D';
		}else if(specialLvl == 'S2'){
			return 'E';
		}else if(specialLvl == 'S3'){
			return 'G';
		}else if(specialLvl == 'S4'){
			return 'J'
		}
	}

	if (batchSize >= 500001) {
		if (specialLvl == 'S1') {
			return 'D';
		}else if(specialLvl == 'S2'){
			return 'E';
		}else if(specialLvl == 'S3'){
			return 'H';
		}else if(specialLvl == 'S4'){
			return 'K';
		}
	}
}