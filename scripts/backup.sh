date
echo ""
echo "Cleaning directory"
rm -rf /backup/*
echo "Done..."

echo ""
echo "Copying files to the backup dir"
cp -R /var/www/* /backup/
echo "Done..."

echo ""
echo "Backing Up SQL Database"
mysqldump -uafficheur -pcesiso --all-databases > sql$(date +%Y%m%d).sql
mv sql$(date +%Y%m%d).sql /backup/
echo "Done..."


echo ""
echo "Compressing Backup"
cd /
tar czf archive$(date +%Y%m%d).tgz backup/
echo "Done..."

#echo ""
#echo "Mounting Backup NAS"
#mkdir /mnt/nas
#mount.cifs //192.168.33.9/public/ANG/ /mnt/nas -o user=backup,pass=cesiso
#echo "Done.."

#echo ""
#echo "Copying backup file"
#cp archive$(date +%Y%m%d).tgz /mnt/nas
#umount.cifs /mnt/nas
#rm -rf /mnt/nas
#rm archive$(date +%Y%m%d).tgz
#echo "Done..."
