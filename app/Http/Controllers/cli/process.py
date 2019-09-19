#!/usr/bin/env python

import sys
import xlrd
import json

# Note.
# process.py [filename] [sheetname] [start] [finish] [row_date] [col_date]
#
# Xlrd.
# comment code at file compdoc.py at line 425
# comment code at file compdoc.py at line 426
# comment code at file compdoc.py at line 427

filename = sys.argv[1]
start = int(sys.argv[2])
wb = xlrd.open_workbook(filename)
sn = wb.sheet_by_index(0)
finish = sn.nrows
data = []

for rownum in range(start, finish):
    data.append(sn.row_values(rownum))

print(json.dumps({
	"data":data
}))
