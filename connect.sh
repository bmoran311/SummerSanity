echo 'Connecting to Summer Sanity Staging Database Server...'
ssh -i bmoran.pub -L 5555:10.116.0.2:3306 forge@165.227.195.171

echo "Starting sleep..."
sleep 10
echo "10 seconds later..."