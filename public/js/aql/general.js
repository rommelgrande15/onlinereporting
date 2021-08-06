//normal inspection
function generalLevel (batchSize, normalLvl){
	if (batchSize >= 2 && batchSize <=8) {
		if (normalLvl == 'I') {
			return 'A';
		}else if(normalLvl == 'II'){
			return 'A';
		}else if(normalLvl ==  'III'){
			return 'B';
		}
	}

	if (batchSize >= 9 && batchSize <=15) {
		if (normalLvl == 'I') {
			return 'A';
		}else if(normalLvl == 'II'){
			return 'B';
		}else if(normalLvl ==  'III'){
			return 'C';
		}
	}

	if (batchSize >= 16 && batchSize <=25) {
		if (normalLvl == 'I') {
			return 'B';
		}else if(normalLvl == 'II'){
			return 'C';
		}else if(normalLvl ==  'III'){
			return 'D';
		}
	}

	if (batchSize >= 26 && batchSize <=50) {
		if (normalLvl == 'I') {
			return 'C';
		}else if(normalLvl == 'II'){
			return 'D';
		}else if(normalLvl ==  'III'){
			return 'E';
		}
	}

	if (batchSize >= 51 && batchSize <=90) {
		if (normalLvl == 'I') {
			return 'C';
		}else if(normalLvl == 'II'){
			return 'E';
		}else if(normalLvl ==  'III'){
			return 'F';
		}
	}

	if (batchSize >= 91 && batchSize <=150) {
		if (normalLvl == 'I') {
			return 'D';
		}else if(normalLvl == 'II'){
			return 'F';
		}else if(normalLvl ==  'III'){
			return 'G';
		}
	}

	if (batchSize >= 151 && batchSize <=280) {
		if (normalLvl == 'I') {
			return 'E';
		}else if(normalLvl == 'II'){
			return 'G';
		}else if(normalLvl ==  'III'){
			return 'H';
		}
	}

	if (batchSize >= 281 && batchSize <=500) {
		if (normalLvl == 'I') {
			return 'F';
		}else if(normalLvl == 'II'){
			return 'H';
		}else if(normalLvl ==  'III'){
			return 'J';
		}
	}

	if (batchSize >= 501 && batchSize <=1200) {
		if (normalLvl == 'I') {
			return 'G';
		}else if(normalLvl == 'II'){
			return 'J';
		}else if(normalLvl ==  'III'){
			return 'K';
		}
	}

	if (batchSize >= 1201 && batchSize <=3200) {
		if (normalLvl == 'I') {
			return 'H';
		}else if(normalLvl == 'II'){
			return 'K';
		}else if(normalLvl ==  'III'){
			return 'L';
		}
	}

	if (batchSize >= 3201 && batchSize <=10000) {
		if (normalLvl == 'I') {
			return 'J';
		}else if(normalLvl == 'II'){
			return 'L';
		}else if(normalLvl ==  'III'){
			return 'M';
		}
	}

	if (batchSize >= 10001 && batchSize <=35000) {
		if (normalLvl == 'I') {
			return 'K';
		}else if(normalLvl == 'II'){
			return 'M';
		}else if(normalLvl ==  'III'){
			return 'N';
		}
	}

	if (batchSize >= 35001 && batchSize <=150000) {
		if (normalLvl == 'I') {
			return 'L';
		}else if(normalLvl == 'II'){
			return 'N';
		}else if(normalLvl ==  'III'){
			return 'P';
		}
	}

	if (batchSize >= 150001 && batchSize <=500000) {
		if (normalLvl == 'I') {
			return 'M';
		}else if(normalLvl == 'II'){
			return 'P';
		}else if(normalLvl ==  'III'){
			return 'Q';
		}
	}

	if (batchSize >= 500001) {
		if (normalLvl == 'I') {
			return 'N';
		}else if(normalLvl == 'II'){
			return 'Q';
		}else if(normalLvl ==  'III'){
			return 'R';
		}
	}
}