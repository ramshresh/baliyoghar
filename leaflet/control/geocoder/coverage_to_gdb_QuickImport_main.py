import os, sys, arcpy

"""
arcpy.QuickImport_interop(
    "ARCINFO,E:/Personal/arcpy/data/2885/09",
    "E:/Personal/arcpy/output/quickimport/test13"
    )

"""
def dir_list_folder(head_dir, dir_name):
    """Return a list of the full paths of the subdirectories
    under directory 'head_dir' named 'dir_name'"""
    dirList = []
    for fn in os.listdir(head_dir):
        #dirfile = os.path.join(head_dir, fn)
        dirfile = head_dir+'/'+ fn
        if os.path.isdir(dirfile):
            if fn.upper() == dir_name.upper():
                dirList.append(dirfile)
            else:
                # print "Accessing directory %s" % dirfile
                dirList += dir_list_folder(dirfile, dir_name)
    return dirList

def get_sheet_number_arr(coverage_dataset_path):
    parts = coverage_dataset_path.split('/')
    sheet_no_parts=parts[-3:-1] # ['2885', 'D14']
    grid_no_str=sheet_no_parts[0] # '2885'  
    sub_grid_str_all=sheet_no_parts[1] # 'D14'
    sub_grid_no_str=''
    sub_grid_no=None
    sub_grid_alpha_str=''
    sub_grid_alpha=None
    if(len(sub_grid_str_all)==3):
        sub_grid_no_str=sub_grid_str_all[-2:]
        sub_grid_alpha_str=sub_grid_str_all[-3:-2]
    elif(len(sub_grid_str_all)==2):
        sub_grid_no_str=sub_grid_str_all

    ## Check Validate 
    if(grid_no_str!=''):
        try:
            int(grid_no_str)
            grid_no=grid_no_str
        except ValueError:
            pass
        
    if(sub_grid_no_str!=''):
        try:
            int(sub_grid_no_str)
            sub_grid_no=sub_grid_no_str
        except ValueError:
            pass

    if(sub_grid_alpha_str!=''):
            sub_grid_alpha = sub_grid_alpha_str
    ## Validation Ends
            
    return [grid_no, sub_grid_no,sub_grid_alpha]
    pass  

def get_central_meridian(sheet_number):
    #use# cm = get_central_meridian(get_sheet_number_arr(input_dataset_path))
    #sheet_number = [2885, 13, 'A']
    grid_no=sheet_number[0]
    sub_grid_no = sheet_number[1]
    sub_grid_alpha =sheet_number[2]

    lon1_deg = int(grid_no[2:4])
    lon2_min=0
    
    if(sub_grid_no in['01','05','09','13']):
        lon2_min = 15*0
        pass
    elif(sub_grid_no in['02','06','10','14']):
        lon2_min = 15*1
        pass
    elif(sub_grid_no in['03','07','11','15']):
        lon2_min = 15*2
        pass
    elif(sub_grid_no in['04','08','12','16']):
        lon2_min = 15*3
        pass

    lon_dd = float(lon1_deg)+float(lon2_min)/60


    if((lon_dd >= 79.5) and lon_dd < 82.5):
        return 81
    elif((lon_dd >= 82.5) and lon_dd < 85.5):
        return 84
    elif((lon_dd >= 85.5) and lon_dd < 88.5):
        return 87  

def quick_import(input_dataset_path,dataset_name,root_dir_output):
    sheet_name = get_sheet_name(input_dataset_path)

    indata = "ARCINFO,"+input_dataset_path
    outdata = root_dir_output+'/'+sheet_name+'_'+dataset_name
    print '********* arcpy.QuickImport with **********************'
    print indata
    print outdata
    try:
        arcpy.QuickImport_interop(indata,outdata)
    except:
        e = sys.exc_info()
        print e 
    print '************************************************'
        
def get_sheet_name(input_dataset_path):
    sheet_number_arr=get_sheet_number_arr(input_dataset_path)
        
    sheet_name = ''
    for sheet_no_part in sheet_number_arr:
        if sheet_no_part is not None:
            sheet_name=sheet_name+'_'+ sheet_no_part

    return sheet_name
        

if __name__ == '__main__':
    root_dir_input = 'E:/NSET/gis_data_backup/NGIIP_CD_NO_072012003_NSET'
    root_dir_output = 'E:/Personal/arcpy/output/all'
    dataset_name= None #'LANDC_AR'
    for dset in ['BUILD_PT','BUILD_AR','HYDRO_LN','HYDRO_AR','LANDC_AR','TOPOG_PT','TOPOG_LN','TRANS_LN','TRANS_AR','UTILI_LN','VIL_NAME','CLIFF_LN']:#ERROR#2882-06-C,2882-05-D#for dset in ['LANDC_AR']: 
        print '##################### Start Importing... '+dset
        dataset_name=dset
        input_dataset_path_list =dir_list_folder(root_dir_input, dataset_name)
        for input_dataset_path in input_dataset_path_list:
            cm = get_central_meridian(get_sheet_number_arr(input_dataset_path))

            output_dir = root_dir_output+'/'+str(cm)
            if not os.path.exists(output_dir):
                os.makedirs(output_dir)
            quick_import(input_dataset_path,dataset_name,output_dir)
        print 'COMPLETED Importing.... '+dset+'###########################################################'
         
   
